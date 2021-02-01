<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

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
        $user = auth()->user();
        $clients = [null];

        if ($user->hasRole('Auditor') || $user->hasRole('Accountant')) {
            $clients = $this->users->clients()->pluck('id')->toArray();
        }

        $vendors = Vendor::query()->where('creator_id', auth()->id())->orWhereIn('creator_id', $clients)->get();
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $clients = $this->users->clients()->pluck('username', 'id');

        return view('vendors.create', ['edit' => false] + compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'name' => 'nullable',
            'vat_number' => 'nullable|unique:vendors'
        ]);

        Vendor::query()->create($request->except('client_id') + [
                'creator_id' => $request->get('client_id') ?? auth()->id()
            ]);
        return redirect()->route('vendors.index')->with('success', __('Vendor created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param Vendor $vendor
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Vendor $vendor)
    {
        $clients = $this->users->clients()->pluck('username', 'id');

        return view('vendors.show', compact('vendor', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Vendor $vendor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'email' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'name' => 'nullable',
            'vat_number' => 'nullable|unique:vendors'
        ]);

        $vendor->update($request->except('client_id') + [
                'creator_id' => $request->get('client_id') ?? auth()->id()
            ]);
        return redirect()->route('vendors.index')->with('success', __('Vendor info updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendors.index')->with('success', __('Vendor deleted successfully.'));
    }
}
