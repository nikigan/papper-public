<?php

namespace Vanguard\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Vanguard\Document;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Filters\DateSearch;
use Vanguard\Http\Filters\DocumentKeywordSearch;
use Vanguard\Http\Resources\DocumentResource;
use Vanguard\Repositories\Document\DocumentRepository;

class DocumentController extends Controller
{

    protected $documentRepository;

    public function __construct( DocumentRepository $documentRepository ) {
        $this->documentRepository = $documentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $documents = $this->documentRepository->currentUserDocuments();

        if ( $request->has( 'query' ) ) {
            ( new DocumentKeywordSearch )( $documents, $request->get( 'query' ) );
        }

        if ( $request->has( 'start_date' ) || $request->has( 'end_date' ) ) {
            ( new DateSearch )( $documents, $request->only( [ 'start_date', 'end_date' ] ), 'document_date' );
        }

        return DocumentResource::collection($documents->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return DocumentResource
     */
    public function show($id)
    {
        return new DocumentResource(Document::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function last()
    {
        $documents = $this->documentRepository->lastModifiedDocuments()->paginate();
        return DocumentResource::collection($documents);
    }

    public function waiting(Request $request)
    {
        $documents = $this->documentRepository->waitingDocuments();
        if ( $request->has( 'query' ) ) {
            ( new DocumentKeywordSearch )( $documents, $request->get( 'query' ) );
        }

        if ( $request->has( 'start_date' ) || $request->has( 'end_date' ) ) {
            ( new DateSearch )( $documents, $request->only( [ 'start_date', 'end_date' ] ), 'document_date' );
        }

        return DocumentResource::collection($documents->paginate());
    }
}
