<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Vanguard\Http\Controllers\Controller;
use Vanguard\PaymentType;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_types = PaymentType::all();
        return view('payment_types.index', compact('payment_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('payment_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:payment_types,name'
        ]);

        PaymentType::query()->create($request->all());

        return redirect()->route('payment_types.index')->with('success', __('Payment type created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PaymentType $paymentType
     */
    public function edit(PaymentType $paymentType)
    {
        return view('payment_types.edit', compact('paymentType'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param PaymentType $paymentType
     */
    public function update(Request $request, PaymentType $paymentType)
    {
        $request->validate([
            'name' => ['required', Rule::unique('payment_types', 'name')->ignore($paymentType->id)]
        ]);

        PaymentType::query()->update($request->all());

        return redirect()->route('payment_types.index')->with('success', __('Payment type updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PaymentType $paymentType
     */
    public function destroy(PaymentType $paymentType)
    {
        $paymentType->delete();

        return redirect()->route('payment_types.index')->with('success', __('Payment type deleted successfully'));
    }
}
