<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Vanguard\DocumentType;
use Vanguard\Http\Controllers\Controller;
use Vanguard\OrganizationType;

class OrganizationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $organization_types = OrganizationType::all();
        return view('organization_types.index', compact('organization_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $document_types = DocumentType::all();
        return view('organization_types.create', compact('document_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', Rule::unique('organization_types', 'name')],
            'document_types' => ['array', 'min:1']
        ]);

        $types = $request->get('document_types');

        $organization_type = OrganizationType::query()->create(['name' =>$request->get('name')]);
        $organization_type->document_types()->sync(array_keys($types));

        return redirect()->route('organization_types.index')->with('success', __('Organization type created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OrganizationType $organizationType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(OrganizationType $organizationType)
    {
        $document_types = DocumentType::all();
        $organizationDocuments = $organizationType->document_types()->pluck('document_types.id')->all();
        return view('organization_types.edit', compact('organizationType', 'document_types', 'organizationDocuments'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param OrganizationType $organizationType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, OrganizationType $organizationType)
    {
        $request->validate([
            'name' => ['required', Rule::unique('organization_types', 'name')->ignore($organizationType->id)],
            'document_types' => 'required|array|min:1'
        ]);

        $types = $request->get('document_types');

        $organizationType->update(['name' =>$request->get('name')]);
        $organizationType->document_types()->sync(array_keys($types));

        return redirect()->route('organization_types.index')->with('success', __('Organization type updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
