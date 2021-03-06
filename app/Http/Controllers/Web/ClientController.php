<?php

namespace Vanguard\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Vanguard\Customer;
use Vanguard\Document;
use Vanguard\Http\Controllers\Controller;
use Vanguard\IncomeType;
use Vanguard\Invoice;
use Vanguard\OrganizationType;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\ClientCard;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;
use Vanguard\Vendor;


class ClientController extends Controller {

    /**
     * @var UserRepository
     */
    private $users;

    private RoleRepository $roles;

    private $token;

    /**
     * UsersController constructor.
     *
     * @param UserRepository $users
     * @param RoleRepository $roles
     */
    public function __construct( UserRepository $users, RoleRepository $roles ) {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function index() {
        $users = $this->users->clients()->paginate( 10 );

        return view( 'clients.index', compact( 'users' ) );
    }

    private function parseCountries( CountryRepository $countryRepository ) {
        return [ 0 => __( 'Select a Country' ) ] + $countryRepository->lists()->toArray();
    }

    public function create( CountryRepository $countryRepository, RoleRepository $roleRepository ) {
        $organization_types = OrganizationType::all()->pluck( 'name', 'id' );
        $income_types       = IncomeType::all()->pluck( 'name', 'id' );

        return view( 'clients.add', [
                                        'countries' => $this->parseCountries( $countryRepository ),
                                        'roles'     => [ 2 => 'User' ],
                                        'statuses'  => UserStatus::lists()
                                    ] + compact( 'organization_types', 'income_types' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store( Request $request ) {
        $request->validate( [
            'email'    => 'required|email|unique:users,email',
            'username' => 'nullable',
            'birthday' => 'nullable|date',
            'passport' => 'unique:users|nullable|numeric',
            'verified' => 'boolean'
        ] );

        $data = $request->all() + [
                'status'            => UserStatus::ACTIVE,
                'email_verified_at' => now(),
                'auditor_id'        => auth()->id(),
                'role_id'           => $this->roles->findByName( 'User' )->id,
                'password'          => Hash::make( Str::random() )
            ];

        if ( ! data_get( $data, 'country_id' ) ) {
            $data['country_id'] = null;
        }

        // Username should be updated only if it is provided.
        if ( ! data_get( $data, 'username' ) ) {
            $data['username'] = null;
        }

        $user  = $this->users->create( $data );
        $token = Crypt::encrypt( $user->id );
        $user->sendEmailAccountCreated( $token );

        return redirect()->route( 'clients.index' )
                         ->withSuccess( __( 'Client created successfully.' ) );
    }


    public function show( $id ) {
        //$user = User::query()->with('documents')->where('id', '=', $id)->get();
        $user            = User::query()->findOrFail( $id );
        $current_user_id = auth()->id();
        if ( ( isset( $user->accountant ) && $user->accountant->id == $current_user_id ) || ( isset( $user->auditor ) && $user->auditor->id == $current_user_id ) ) {
            $documents = Document::query()
                                 ->where( 'user_id', $id )
                                 ->orderByDesc( 'document_date' );

            $months = $documents->get()->groupBy( function ( $d ) {
                return Carbon::parse( $d->document_date )->format( 'm/y' );
            } );

            $invoices = Invoice::query()
                               ->where( 'creator_id', $id )
                               ->orderByDesc( 'invoice_date' );

            $invoices_months = $invoices->get()->groupBy( function ( $d ) {
                return Carbon::parse( $d->invoice_date )->format( 'm/y' );
            } );


            $result    = [];
            $total_sum = 0;
            $total_vat = 0;
            foreach ( $months as $date => $month ) {
                $sum = 0;
                $vat = 0;
                foreach ( $month as $doc ) {

                    if ( $doc->status == 'Confirmed' ) {
                        $k   = $doc->document_type ? 1 : - 1;
                        $sum += $k * $doc->getConvertedSum();
                        $vat += $k * $doc->getConvertedVat();
                    }
                }
                $total_sum       += $sum;
                $total_vat       += $vat;
                $result[ $date ] = [
                    'sum'   => $sum,
                    'vat'   => $vat,
                    'class' => $sum >= 0 ? 'text-success' : 'text-danger'
                ];
            }

            foreach ( $invoices_months as $date => $month ) {
                $sum = 0;
                $vat = 0;
                foreach ( $month as $invoice ) {
                    $tax = ( $invoice->total_amount * $invoice->tax_percent / 100 ) / $invoice->currency->value;
                    $sum += $invoice->total_amount + ( $invoice->include_tax ? 0 : - 1 * $tax ) / $invoice->currency->value;
                    $vat += $tax;
                }
                $total_sum       += $sum;
                $total_vat       += $vat;
                $result[ $date ] = [
                    'sum'   => ( $result[ $date ]['sum'] ?? 0 ) + $sum,
                    'vat'   => ( $result[ $date ]['vat'] ?? 0 ) + $vat,
                    'class' => $sum >= 0 ? 'text-success' : 'text-danger'
                ];
            }

            uksort( $result,
                function ( $dt1, $dt2 ) {
                    $tm1 = Carbon::createFromFormat( 'm/y', $dt1 );
                    $tm2 = Carbon::createFromFormat( 'm/y', $dt2 );

                    return ( $tm1 < $tm2 ) ? 1 : ( ( $tm1 > $tm2 ) ? - 1 : 0 );
                } );
            $sum_class    = $total_sum > 0 ? 'text-success' : 'text-danger';
            $current_user = auth()->user();
            $invoices     = $invoices->paginate();
            $documents    = $documents->paginate();

            $last_card      = new ClientCard( 'Waiting documents', route( 'clients.waiting', [ 'client' => $user ] ), 'Show', $user->documents->where( 'status', DocumentStatus::UNCONFIRMED )->count() );
            $customers_card = new ClientCard( 'Customers', route( 'clients.customers', [ 'client' => $user ] ), 'Show', Customer::query()->where( 'creator_id', $id )->count() );
            $vendors_card   = new ClientCard( 'Vendors', route( 'clients.vendors', [ 'client' => $user ] ), 'Show', Vendor::query()->where( 'creator_id', $id )->count() );

            if ( $user->notify && $user->last_login && $user->last_login->diffInDays( Carbon::now() ) >= $user->notification_rate ) {
                $flash = __( "User hasn't been logged in for :days days", [ 'days' => $user->notification_rate ] );
                Session::flash( 'warning', $flash );
            }

            return view( 'clients.show',
                [ 'monthly_docs' => $result, 'sum' => $total_sum, 'vat' => $total_vat ]
                + compact( 'user', 'current_user', 'sum_class', 'current_user_id', 'invoices', 'documents', 'invoices', 'last_card', 'customers_card', 'vendors_card' ) );
        }

        return redirect()->back()->withErrors( __( 'You cannot look at client that is not yours' ) );
    }


    public function info( User $client ) {
        $organization_types = OrganizationType::all()->pluck( 'name', 'id' );
        $income_types       = IncomeType::all()->pluck( 'name', 'id' );

        return view( 'clients.info', compact( 'client', 'organization_types', 'income_types' ) );
    }

    public function documents( Request $request, User $client ) {
        $month = $request->query( 'month' );
        $year  = $request->query( 'year' );

        if ( $month && $year ) {
            $documents = Document::query()->where( 'user_id', $client->id )
                                 ->whereMonth( 'document_date', $month )
                                 ->whereYear( 'document_date', 20 . $year )
                                 ->paginate( 10 );

            $invoices = Invoice::query()->where( 'creator_id', $client->id )
                               ->whereMonth( 'invoice_date', $month )
                               ->whereYear( 'invoice_date', 20 . $year )
                               ->paginate( 10 );
        } else {
            $documents = Document::query()->where( 'user_id', $client->id )->paginate( 10 );
            $invoices  = Invoice::query()->where( 'creator_id', $client->id )->paginate( 10 );
        }

        return view( 'clients.documents.show', [ 'user' => $client ] + compact( 'documents', 'year', 'month', 'invoices' ) );
    }

    public function editAccountant( $user_id, $accountant_id ) {
        User::find( $user_id )->update( [
            'accountant_id' => $accountant_id
        ] );

        return redirect()->back();
    }

    public function last( $id ) {
        $user      = User::query()->findOrFail( $id );
        $documents = Document::query()->where( 'user_id', $user->id )->orderByDesc( 'updated_at' )->limit( 20 )->get();

        return view( 'clients.documents.last', [ 'waiting' => false ] + compact( 'user', 'documents' ) );
    }

    public function waiting( $id ) {
        $user      = User::query()->findOrFail( $id );
        $documents = Document::query()->where( 'user_id', $user->id )->where( 'status', '=', DocumentStatus::UNCONFIRMED )->orderByDesc( 'document_date' )->paginate( 10 );

        return view( 'clients.documents.last', [ 'waiting' => true ] + compact( 'user', 'documents' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit( $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update( Request $request, int $id ) {
        $this->users->update( $id, $request->except( 'role_id', 'status' ) );

        return redirect()->route( 'clients.show', $id )->with( 'success', __( 'Client`s info updated successfully.' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy( $id ) {
        //
    }
}
