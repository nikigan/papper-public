<?php

namespace Vanguard\Http\Controllers\Web;

use Hash;
use Illuminate\Http\Request;
use Imagick;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use Vanguard\Currency;
use Vanguard\Document;
use Vanguard\DocumentType;
use Vanguard\ExpenseType;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Filters\DocumentKeywordSearch;
use Vanguard\Jobs\ProcessDocument;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Services\YandexVision;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\Support\Plugins\Vendors;
use Vanguard\Vendor;

class DocumentController extends Controller
{

    /**
     * UploadDocument constructor.
     */

    protected $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->middleware('auth');
        $this->documentRepository = $documentRepository;
    }

    public function index(Request $request)
    {
        $current_user = auth()->user();
        if ($current_user->hasRole('Auditor') || $current_user->hasRole('Admin') || $current_user->hasRole('Accountant')) {
            $documents = Document::query()
                ->whereHas('user', function ($q) use ($current_user) {
                    $q->where('auditor_id', $current_user->id)
                        ->orWhere('accountant_id', $current_user->id);
                })
                ->orderByDesc('document_date');
        } else {
            $documents = Document::query()
                ->with('user')
                ->where('user_id', '=', $current_user->id)
                ->orderByDesc('created_at');
        }

        if ($request->get('query')) {
            (new DocumentKeywordSearch)($documents, $request->get('query'));
        }

        $start_date = $request->get('start_date') ?? false;
        $end_date = $request->get('end_date') ?? false;

        if ($start_date) {
            $documents = $documents->whereDate('document_date', '>=', $start_date);
        }

        if ($end_date) {
            $documents = $documents->whereDate('document_date', '<=', $end_date);
        }

        $documents = $documents->paginate(10);
        $statuses = DocumentStatus::lists();
        return view('document.index', compact('documents', 'statuses', 'current_user'));
    }

    public function waiting(Request $request)
    {
        $documents = $this->documentRepository->documentsAuditor();
        $start_date = $request->get('start_date') ?? false;
        $end_date = $request->get('end_date') ?? false;

        if ($request->get('query')) {
            (new DocumentKeywordSearch)($documents, $request->get('query'));
        }
        if ($start_date) {
            $documents = $documents->whereDate('document_date', '>=', $start_date);
        }

        if ($end_date) {
            $documents = $documents->whereDate('document_date', '<=', $end_date);
        }

        $documents = $documents->where('status', DocumentStatus::UNCONFIRMED)->paginate(10);
        $statuses = DocumentStatus::lists();
        $current_user = auth()->user();

        return view('document.index', compact('documents', 'statuses', 'current_user'));

    }

    public function show(Document $document)
    {
        $currencies = Currency::all();
        $vendors = Vendor::all();
        $isPdf = false;
        if ($document->file) {
            $isPdf = mime_content_type($document->file) == 'application/pdf';
        }
        $statuses = DocumentStatus::lists();
        $expense_types = ExpenseType::all();
        return view('document.show', ['document' => $document, 'isPdf' => $isPdf, 'statuses' => $statuses, 'currencies' => $currencies, 'vendors' => $vendors, 'expense_types' => $expense_types]);
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

        if ($request->hasFile('file')) {

            $filename = $request->file('file')->getClientOriginalName();

            /*if ($request->file('file')->getMimeType() == "application/pdf") {
                $imagick = new Imagick();
                try {
                    $folder = auth()->id();
                    $date = date('Y-m-d');
                    if (!is_dir("/upload/documents/$folder")) {
                        mkdir("/upload/documents/$folder", 0755, true);
                    }
                    if (!is_dir("/upload/documents/$folder/$date")) {
                        mkdir("/upload/documents/$folder/$date", 0755, true);
                    }
                    $path = "upload/documents/$folder/$date/$filename.png";
                    $imagick->setResolution('300', '300');
                    $imagick->setBackgroundColor('white');
                    $imagick->readImage($request->file('file')->path());
                    $imagick->setImageBackgroundColor('white');
                    //$imagick->setImageAlphaChannel(Imagick::VIRTUALPIXELMETHOD_WHITE);
                    $imagick->setImageFormat('png');
                    $imagick->writeImageFile(fopen($path, "wb"));
                    $file = $path;
                } catch (\ImagickException $e) {
                    dd($e);
                }
            } else {*/
            $folder = auth()->id();
            $date = date('Y-m-d');
            $file = $request->file('file')->store("upload/documents/{$folder}/{$date}", 'public');
            //}


            $document = Document::query()->create([
                'user_id' => auth()->id(),
                'file' => $file
            ]);


            ProcessDocument::dispatch($file, $document);

            return redirect()->route('documents.index')->withSuccess(__('Document uploaded successfully.'));
        }
        return redirect()->with('error', 'File is missing');
    }

    public function create()
    {
        $currencies = Currency::all();
        $vendors = Vendor::all();
        $expense_types = ExpenseType::all();
        $document_types = DocumentType::all();
        return view('document.create', compact('currencies', 'vendors', 'expense_types', 'document_types'));
    }

    public function manualStore(Request $request)
    {
        $request->validate([
            'document_number' => 'required|unique:documents',
            'sum' => 'required|numeric',
            'vat' => 'required|numeric',
            'file' => 'file'
        ]);

        $sum_without_vat = $request->sum - $request->vat;

        $file = null;

        if ($request->file) {
            $folder = auth()->id();
            $date = date('Y-m-d');
            $file = $request->file('file')->store("upload/documents/{$folder}/{$date}", 'public');
        }

        Document::create($request->except('file') + [
                'file' => $file,
                'sum_without_vat' => $sum_without_vat,
                'user_id' => auth()->id(),
                'expense_type_id' => $request->get('expense_type_id'),
                'income_type_id' => $request->get('income_type_id')]);

        return redirect()->route('documents.index')->withSuccess(__('Document created successfully'));
    }

    public function update(Request $request, Document $document)
    {
        $sum_without_vat = $request->sum - $request->vat;
        $document->update($request->all() + ['sum_without_vat' => $sum_without_vat, 'expense_type_id' => $request->get('expense_type_id'),
                'income_type_id' => $request->get('income_type_id')]);
        return redirect()->route('documents.show', $document)->withSuccess(__('Document updated successfully.'));
    }

    public function destroy(Document $document)
    {
        if ($document->file) {
            Storage::disk('public')->delete($document->file);
        }
        $document->delete();
        return redirect()->back()->withSuccess(__("Document deleted successfully"));
    }
}
