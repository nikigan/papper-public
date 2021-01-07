<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Vanguard\ExpenseGroup;
use Vanguard\Http\Controllers\Controller;

class ExpenseGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $expense_groups = ExpenseGroup::all();

        return view('expense_groups.index', compact('expense_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('expense_groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:expense_groups'
        ]);

        ExpenseGroup::query()->create($request->all());
        return redirect()->route('expense_groups.index')->with('success', __('Expense group created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param ExpenseGroup $expenseGroup
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(ExpenseGroup $expenseGroup)
    {
        return view('expense_groups.edit', compact('expenseGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ExpenseGroup $expenseGroup
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(ExpenseGroup $expenseGroup)
    {
        return view('expense_groups.edit', compact('expenseGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ExpenseGroup $expenseGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ExpenseGroup $expenseGroup): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['required', Rule::unique('expense_groups', 'name')->ignore($expenseGroup->id)]
        ]);

        $expenseGroup->update($request->all());

        return redirect()->route('expense_groups.index')->with('success', __('Expense group updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ExpenseGroup $expenseGroup
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ExpenseGroup $expenseGroup)
    {
        $expenseGroup->delete();
        return redirect()->route('expense_groups.index')->with('success', __('Expense group deleted successfully.'));
    }
}
