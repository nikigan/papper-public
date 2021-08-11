<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Vanguard\ExpenseType;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\User;
use Vanguard\Vendor;

class VendorController extends Controller {
    /**
     * Display a listing of the resource.
     *
     */

    /**
     * UsersController constructor.
     * @param UserRepository $users
     * @param RoleRepository $roles
     */
    public function __construct(UserRepository $users, RoleRepository $roles) {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function index(?User $client) {
        $user    = auth()->user();
        $clients = [null];

        if (($user->hasRole('Auditor') || $user->hasRole('Accountant')) && !$client) {
            $clients = $this->users->clients()->pluck('id')->toArray();
        }


        $vendors = Vendor::query()->where('creator_id', $client->id ?? auth()->id())->orWhereIn('creator_id', $clients)->get();

        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Request $request) {
        $selected_client = $request->get('selected_client');
        $clients         = $this->users->clients()->pluck('username', 'id');

        return view('vendors.create', ['edit' => false] + compact('clients', 'selected_client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request) {
        $request->validate([
            'email'      => 'nullable',
            'phone'      => 'nullable',
            'address'    => 'nullable',
            'name'       => 'nullable',
            'vat_number' => 'required|unique:vendors'
        ]);

        $vendor = Vendor::query()->create( $request->except('client_id') + [
                'creator_id' => $request->get('client_id') ?? auth()->id()
            ]);

        if ($request->expectsJson()) {
            return $vendor;
        }

        return redirect()->route('vendors.index')->with('success', __('Vendor created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param Vendor $vendor
     *
     * @return Application|Factory|Response|View
     */
    public function show(Vendor $vendor) {
        $clients       = $this->users->clients()->pluck( 'username', 'id' );
        $documents     = $vendor->documents()->paginate();
        $expense_types = ExpenseType::all();

        return view( 'vendors.show', compact( 'vendor', 'clients', 'documents', 'expense_types' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Vendor $vendor
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Vendor $vendor) {
        $request->validate([
            'email'      => 'nullable',
            'phone'      => 'nullable',
            'address'    => 'nullable',
            'name'       => 'nullable',
            'vat_number' => 'nullable|unique:vendors'
        ]);

        $vendor->update( $request->except('client_id') + [
                'creator_id' => $request->get('client_id') ?? auth()->id()
            ]);

        return redirect()->route('vendors.index')->with('success', __('Vendor info updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(Vendor $vendor) {
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', __('Vendor deleted successfully.'));
    }
}
