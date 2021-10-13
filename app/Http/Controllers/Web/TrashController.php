<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\Repositories\Document\DocumentRepository;

class TrashController extends Controller {

    protected DocumentRepository $documentRepository;

    public function __construct( DocumentRepository $documentRepository ) {
        $this->documentRepository = $documentRepository;
    }

    public function index() {
        $documents = $this->documentRepository->currentUserDocuments()->onlyTrashed();
        $invoices  = Invoice::currentUserInvoices()->onlyTrashed()->paginate();

        $list      = $documents->pluck( "id" );
        $documents = $documents->paginate();

        return view( 'trash.index', compact( 'documents', 'invoices', 'list' ) );
    }
}
