<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Vanguard\IncomeGroup;
use Vanguard\IncomeType;
use Vanguard\Http\Controllers\Controller;

class IncomeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $income_types = IncomeType::all();
        return view('income_types.index', compact('income_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $income_groups = IncomeGroup::all();
        return view('income_types.create', compact('income_groups'));
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
            'name' => 'required|unique:income_types'
        ]);

        IncomeType::create($request->all());
        return redirect()->route('income_types.index')->with('success', __('Income type created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeType $incomeType)
    {
        $income_groups = IncomeGroup::all();

        return view('income_types.edit', compact('incomeType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomeType $incomeType)
    {
        $income_groups = IncomeGroup::all();
        return view('income_types.edit', compact('incomeType', 'income_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncomeType $incomeType)
    {
        $request->validate([
            'name' => ['required', Rule::unique('income_types', 'name')->ignore($incomeType->id)]
        ]);

        $incomeType->update($request->all());

        return redirect()->route('income_types.index')->with('success', __('Income type updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomeType $incomeType)
    {
        $incomeType->delete();
        return redirect()->route('income_types.index')->with('success', __('Income type deleted successfully.'));
    }
}
