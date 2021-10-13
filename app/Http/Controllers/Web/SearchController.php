<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Filters\DateSearch;
use Vanguard\Http\Filters\DocumentKeywordSearch;
use Vanguard\Http\Filters\InvoiceSearch;
use Vanguard\Http\Filters\UserKeywordSearch;
use Vanguard\Invoice;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Repositories\User\UserRepository;

class SearchController extends Controller
{

    protected UserRepository $users;
    protected DocumentRepository $documents;

    /**
     * SearchController constructor.
     * @param UserRepository $users
     * @param DocumentRepository $documents
     */
    public function __construct(UserRepository $users, DocumentRepository $documents)
    {
        $this->users = $users;
        $this->documents = $documents;
    }

    public function index(Request $request) {
        $query = $request->get('query') ?? "";
        $start_date = $request->get('start_date') ?? null;
        $end_date = $request->get('end_date') ?? null;

        $clients = $this->users->clients();
        (new UserKeywordSearch)($clients, $query);
        $clients = $clients->paginate(10, ['*'], 'client_page');

        $documents = $this->documents->documentsAuditor();

        ( new DocumentKeywordSearch )( $documents, $query );

        ( new DateSearch )( $documents, compact( 'end_date', 'start_date' ), 'document_date' );

        $invoices = Invoice::query()->whereHas( 'creator', function ( $q ) {
            $q->where( 'auditor_id', auth()->id() )
              ->orWhere( 'accountant_id', auth()->id() );
        } )->orderByDesc( 'invoice_date' );

        ( new InvoiceSearch )( $invoices, $query );

        $list = $documents->pluck( "id" );

        $documents = $documents->paginate( 10, [ '*' ], 'document_page' );


        $invoices = $invoices->paginate( 10, [ '*' ], 'invoice_page' );

        return view( 'search.index', compact( 'clients', 'documents', 'invoices', 'list' ) );
    }

    public function autocomplete(Request $request) {
        $query = $request->get('query');

        $documents = $this->documents->currentUserDocuments();
        $invoices = Invoice::currentUserInvoices();
        $clients = $this->users->clients();

        (new DocumentKeywordSearch)($documents, $query);
        (new InvoiceSearch)($invoices, $query);
        (new UserKeywordSearch)($clients, $query);

        $documents = $documents->limit(5)->get();
        $invoices = $invoices->limit(5)->get();
        $clients = $clients->limit(5)->get();

        return response()->json(compact('documents', 'invoices', 'clients'));

    }
}
