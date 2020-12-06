<?php

namespace Vanguard\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Vanguard\Document;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;

class ClientController extends Controller
{

    /**
     * @var UserRepository
     */
    private $users;

    private RoleRepository $roles;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     * @param RoleRepository $roles
     */
    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function index()
    {
        $users = User::query()
            ->where(function($q){
                $q->where('auditor_id', auth()->id())
                ->orWhere('accountant_id', auth()->id());
            })
            ->where('role_id', '<>', 4)
            ->get();
        return view('clients.index', compact('users'));
    }

    private function parseCountries(CountryRepository $countryRepository)
    {
        return [0 => __('Select a Country')] + $countryRepository->lists()->toArray();
    }

    public function create(CountryRepository $countryRepository, RoleRepository $roleRepository)
    {
        return view('clients.add', [
            'countries' => $this->parseCountries($countryRepository),
            'roles' => [2 => 'User'],
            'statuses' => UserStatus::lists()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'nullable',
            'password' => 'required|min:6|confirmed',
            'birthday' => 'nullable|date',
            'verified' => 'boolean'
        ]);

        $data = $request->all() + [
                'status' => UserStatus::ACTIVE,
                'email_verified_at' => now(),
                'auditor_id' => auth()->id(),
                'role_id' => $this->roles->findByName('User')->id
            ];

        if (! data_get($data, 'country_id')) {
            $data['country_id'] = null;
        }

        // Username should be updated only if it is provided.
        if (! data_get($data, 'username')) {
            $data['username'] = null;
        }

        $this->users->create($data);

        return redirect()->route('clients.index')
            ->withSuccess(__('Client created successfully.'));
    }


    public function show($id)
    {
        //$user = User::query()->with('documents')->where('id', '=', $id)->get();
        $user = User::query()->findOrFail($id);
        $current_user_id = auth()->id();
        if ((isset($user->accountant) || isset($user->auditor))) {
            if ($user->accountant->id == $current_user_id || $user->auditor->id == $current_user_id) {
                $documents = Document::query()->where('user_id', $id)->orderByDesc('document_date')->get();
                $months = $documents->groupBy(function ($d) {
                    return Carbon::parse($d->document_date)->format('m/y');
                });

                $result = [];
                $total_sum = 0;
                $total_vat = 0;
                foreach ($months as $date => $month) {
                    $sum = 0;
                    $vat = 0;
                    foreach ($month as $doc) {

                        if ($doc->status == 'Confirmed') {
                            $k = $doc->document_type ? 1 : -1;
                            $sum += $k * $doc->sum;
                            $vat += $k * $doc->vat;
                        }
                    }
                    $total_sum += $sum;
                    $total_vat += $vat;
                    $result[$date] = ['sum' => $sum, 'vat' => $vat, 'class' => $sum >= 0 ? 'text-success' : 'text-danger'];
                }
                /*$sum = 0;
                $vat = 0;
                foreach ($documents as $document) {
                    if ($document->status == 'Confirmed') {
                        $k = $document->document_type ? 1 : -1;
                        $sum += $k * $document->sum;
                        $vat += $k * $document->vat;
                    }
                }
                $sum_class = $sum > 0 ? 'text-success' : 'text-danger';*/
                $sum_class = $total_sum > 0 ? 'text-success' : 'text-danger';
                $current_user = auth()->user();
                return view('clients.show',
                    ['monthly_docs' => $result, 'sum' => $total_sum, 'vat' => $total_vat]
                    + compact('user', 'current_user', 'sum_class', 'current_user_id'));
            }
        }

        return redirect()->back()->withErrors(__('You cannot look at client that is not yours'));
    }

    public function documents (Request $request, User $client) {
        $month = $request->query('month');
        $year = $request->query('year');

        if ($month && $year) {
            $documents = Document::query()->where('user_id', $client->id)
                ->whereMonth('document_date', $month)
                ->whereYear('document_date', 20 . $year)
                ->paginate(2);
        } else {
            $documents = Document::query()->where('user_id', $client->id)->paginate(10);
        }

        return view('clients.documents.show', ['user' => $client] + compact('documents', 'year', 'month'));
    }

    public function editAccountant($user_id, $accountant_id) {
        User::find($user_id)->update([
            'accountant_id' => $accountant_id
        ]);
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
