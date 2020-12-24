<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Filters\DocumentKeywordSearch;
use Vanguard\Http\Filters\UserKeywordSearch;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\User;

class SearchController extends Controller
{

    protected $users;
    protected $documents;

    /**
     * SearchController constructor.
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
        $clients = $clients->get();

        $documents = $this->documents->documentsAuditor();
        (new DocumentKeywordSearch)($documents, $query);
        if ($end_date) {
            $documents = $documents->where('document_date', '<=', $end_date);
        }

        if ($start_date) {
            $documents = $documents->where('document_date', '>=', $start_date);
        }
        $documents = $documents->get();
        dump($documents);
        dump($clients);

        return view('search.index', compact('clients', 'documents'));
    }
}
