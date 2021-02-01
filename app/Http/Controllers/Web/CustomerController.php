<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Customer;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;

class CustomerController extends Controller
{

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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $clients = [null];

        if ($user->hasRole('Auditor') || $user->hasRole('Accountant')) {
            $clients = $this->users->clients()->pluck('id')->toArray();
        }

        $customers = Customer::query()->where('creator_id', auth()->id())->orWhereIn('creator_id', $clients)->get();
        return view('customers.index', compact('customers', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Request $request)
    {
        $selected_client = $request->get('selected_client');

        $clients = $this->users->clients()->pluck('username', 'id');

        return view('customers.create', ['edit' => false] + compact('clients', 'selected_client'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'name' => 'nullable',
            'vat_number' => 'nullable|unique:customers'
        ]);

        Customer::query()->create($request->except('client_id') + [
                'creator_id' => $request->get('client_id') ?? auth()->id()
            ]);
        return redirect()->route('customers.index')->with('success', __('Customer created successfully'));
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Customer $customer)
    {
        $clients = $this->users->clients()->pluck('username', 'id');

        return view('customers.show', compact('customer', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'email' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'name' => 'nullable',
            'vat_number' => 'nullable|unique:customers'
        ]);

        $customer->update($request->except('client_id') + [
                'creator_id' => $request->get('client_id') ?? auth()->id()
            ]);
        return redirect()->route('customers.index')->with('success', __('Customer info updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->back()->with('success', 'Customer deleted successfylly');
    }
}
