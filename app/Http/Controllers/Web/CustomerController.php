<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Customer;
use Vanguard\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::query()->where('creator_id', auth()->id())->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('customers.create', ['edit' => false]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'name' => 'required',
            'vat_number' => 'required|unique:customers'
        ]);

        Customer::query()->create($request->all() + [
            'creator_id' => auth()->id()
            ]);
        return redirect()->route('customers.index')->with('success', __('Customer created successfully'));
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'name' => 'required',
            'vat_number' => 'required|unique:customers'
        ]);

        $customer->update($request->all());
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
