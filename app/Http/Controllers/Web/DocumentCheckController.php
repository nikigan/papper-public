<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vanguard\DocumentCheck;
use Vanguard\Http\Controllers\Controller;

class DocumentCheckController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view( 'document_check.index' )->with( [ 'document_checks' => DocumentCheck::all() ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view( 'document_check.edit' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store( Request $request ) {
        DocumentCheck::create( $request->all() );

        return redirect()->route( 'document_check.index' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit( DocumentCheck $document_check ) {
        return view( 'document_check.edit', compact( 'document_check' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function update( Request $request, DocumentCheck $document_check ) {
        $document_check->update( $request->all() );

        return redirect()->route( 'document_check.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy( DocumentCheck $document_check ) {
        $document_check->delete();

        return redirect()->route( 'document_check.index' );
    }
}
