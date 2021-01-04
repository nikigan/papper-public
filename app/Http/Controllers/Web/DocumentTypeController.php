<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Vanguard\DocumentType;
use Vanguard\Http\Controllers\Controller;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $document_types = DocumentType::all();
        return view('document_types.index', compact('document_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('document_types.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:document_types,name',
            'prefix' => 'required|unique:document_types,prefix'
        ]);

        DocumentType::query()->create($request->all());
        return redirect()->route('document_types.index')->with('success', __('Document type created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param DocumentType $documentType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(DocumentType $documentType)
    {
        return view('document_types.edit', compact('documentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DocumentType $documentType
     */
    public function update(Request $request, DocumentType $documentType)
    {
        $request->validate([
            'name' => ['required', Rule::unique('document_types')->ignore($documentType->id)],
            'prefix' => ['required', Rule::unique('document_types')->ignore($documentType->id)]
        ]);

        $documentType->update($request->all());
        return redirect()->route('document_types.index')->with('success', __('Document type updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DocumentType $documentType
     */
    public function destroy(DocumentType $documentType)
    {
        $documentType->delete();
        return redirect()->route('document_types.index')->with('success', __('Document type deleted successfully'));
    }
}
