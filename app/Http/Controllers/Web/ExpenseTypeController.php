<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Vanguard\ExpenseGroup;
use Vanguard\ExpenseType;
use Vanguard\Http\Controllers\Controller;
use Vanguard\VatRate;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense_types = ExpenseType::all();
        return view('expense_types.index', compact('expense_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expense_groups = ExpenseGroup::all();
        $vat_rates = VatRate::all();

        return view('expense_types.create', compact('expense_groups', 'vat_rates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:expense_types'
        ]);

        ExpenseType::create($request->all());

        return redirect()->route('expense_types.index')->with('success', __('Expense type created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseType $expenseType)
    {
        $expense_groups = ExpenseGroup::all();
        $vat_rates = VatRate::all();


        return view('expense_types.edit', compact('expenseType', 'expense_groups', 'vat_rates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseType $expenseType)
    {
        $request->validate([
            'name' => ['required', Rule::unique('expense_types', 'name')->ignore($expenseType->id)]
        ]);

        $expenseType->update($request->all());

        return redirect()->route('expense_types.index')->with('success', __('Expense type updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseType $expenseType)
    {
        $expenseType->delete();
        return redirect()->route('expense_types.index')->with('success', __('Expense type deleted successfully.'));
    }
}
