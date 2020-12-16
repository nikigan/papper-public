<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Vanguard\Currency;
use Vanguard\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::all();
        return view('currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:currencies,name',
            'iso_code' => 'required|max:3|unique:currencies,iso_code',
            'sign' => 'required',
            'value' => 'required|numeric'
        ]);

        Currency::query()->create($request->all());
        return redirect()->route('currency.index')->with('success', __('Currency created successfully.'));
    }

    /**
     * Display the specified resource.
     * @param Currency $currency
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Currency $currency
     */
    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Currency  $currency
     */
    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => ['required', Rule::unique('currencies', 'name')->ignore($currency->id)],
            'iso_code' => ['required|max:3', Rule::unique('currencies', 'iso_code')->ignore($currency->id)],
            'sign' => 'required',
            'value' => 'required|numeric'
        ]);

        $currency->update($request->all());
        return redirect()->route('currency.index')->with('success', __('Currency updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Currency $currency
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return redirect()->route('currency.index')->with('success', __('Currency deleted successfully'));
    }
}
