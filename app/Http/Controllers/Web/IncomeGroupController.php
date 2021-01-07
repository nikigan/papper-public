<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Vanguard\IncomeGroup;
use Vanguard\Http\Controllers\Controller;

class IncomeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $income_groups = IncomeGroup::all();

        return view('income_groups.index', compact('income_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('income_groups.create');
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
            'name' => 'required|unique:income_groups'
        ]);

        IncomeGroup::query()->create($request->all());
        return redirect()->route('income_groups.index')->with('success', __('Income group created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param IncomeGroup $incomeGroup
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(IncomeGroup $incomeGroup)
    {
        return view('income_groups.edit', compact('incomeGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param IncomeGroup $incomeGroup
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(IncomeGroup $incomeGroup)
    {
        return view('income_groups.edit', compact('incomeGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param IncomeGroup $incomeGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, IncomeGroup $incomeGroup): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['required', Rule::unique('income_groups', 'name')->ignore($incomeGroup->id)]
        ]);

        $incomeGroup->update($request->all());

        return redirect()->route('income_groups.index')->with('success', __('Income group updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IncomeGroup $incomeGroup
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(IncomeGroup $incomeGroup)
    {
        $incomeGroup->delete();
        return redirect()->route('income_groups.index')->with('success', __('Income group deleted successfully.'));
    }
}
