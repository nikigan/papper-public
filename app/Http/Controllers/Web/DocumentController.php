<?php

namespace Vanguard\Http\Controllers\Web;

use Hash;
use Illuminate\Http\Request;
use Imagick;
use Storage;
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
        if ($current_user->hasRole('Auditor') || $current_user->hasRole('Admin') || $current_user->hasRole('Accountant')) {
            $documents = Document::query()
                ->whereHas('user', function($q) use ($current_user) {
                    $q->where('auditor_id', $current_user->id)
                    ->orWhere('accountant_id', $current_user->id);
                })
                ->orderByDesc('document_date')
                ->paginate(10);
        } else {
            $documents = Document::query()
                ->with('user')
                ->where('user_id', '=', $current_user->id)
                ->orderByDesc('document_date')->paginate(10);
        }
        $statuses = DocumentStatus::lists();
        return view('document.index', compact('documents', 'statuses', 'current_user'));
    }

    public function show(Document $document)
    {
        $isPdf = false;
        if ($document->file) {
            $isPdf = mime_content_type($document->file) == 'application/pdf';
        }
        $statuses = DocumentStatus::lists();
        return view('document.show', ['document' => $document, 'isPdf' => $isPdf, 'statuses' => $statuses]);
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
        return view('document.create');
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
                'user_id' => auth()->id()]);

        return redirect()->route('documents.index')->withSuccess(__('Document created successfully'));
    }

    public function update(Request $request, Document $document)
    {
        $sum_without_vat = $request->sum - $request->vat;
        $document->update($request->all() + ['sum_without_vat' => $sum_without_vat]);
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
