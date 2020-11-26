<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Document;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Jobs\ProcessDocument;
use Vanguard\Services\YandexVision;
use Vanguard\Support\Enum\DocumentStatus;

class DocumentController extends Controller
{

    /**
     * UploadDocument constructor.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $current_user = auth()->user();
        if ($current_user->hasRole('Auditor') || $current_user->hasRole('Admin')) {
            $documents = Document::with('user')->orderByDesc('created_at')->get();
        } else {
            $documents = Document::query()->with('user')->where('user_id', '=', $current_user->id)->orderByDesc('created_at')->get();
        }
        $statuses = DocumentStatus::lists();
        return view('document.index', compact('documents', 'statuses', 'current_user'));
    }

    public function show(Document $document)
    {
        return view('document.show', ['document' => $document]);
    }

    public function upload()
    {
        return view('document.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $file = $request->file('file')->store('documents');

        $document = Document::query()->create([
            'user_id' => auth()->user()->getAuthIdentifier(),
            'file' => $file
        ]);

        ProcessDocument::dispatchAfterResponse($request->file('file')->path(), $document);

        return redirect()->route('documents.index')->withSuccess(__('Document uploaded successfully.'));

    }
}
