<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Vanguard\Currency;
use Vanguard\Customer;
use Vanguard\Document;
use Vanguard\ExpenseType;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Filters\DateSearch;
use Vanguard\Http\Filters\DocumentKeywordSearch;
use Vanguard\Http\Filters\MonthFilter;
use Vanguard\IncomeType;
use Vanguard\Jobs\ProcessDocument;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\User;
use Vanguard\Vendor;

class DocumentController extends Controller {

    /**
     * UploadDocument constructor.
     */

    protected DocumentRepository $documentRepository;

    public function __construct( DocumentRepository $documentRepository ) {
        $this->middleware( 'auth' );
        $this->documentRepository = $documentRepository;
    }

    public function index( Request $request ) {
        $documents = $this->documentRepository->currentUserDocuments();

        if ( $request->has( 'query' ) ) {
            ( new DocumentKeywordSearch )( $documents, $request->get( 'query' ) );
        }

        if ( $request->has( 'start_date' ) || $request->has( 'end_date' ) ) {
            ( new MonthFilter )( $documents, $request->only( [ 'start_date', 'end_date' ] ), 'document_date' );
        }

        $documents = $documents->paginate( 10 );

        return view( 'document.index', compact( 'documents' ) );
    }

    public function waiting( Request $request ) {
        $documents = $this->documentRepository->documentsAuditor();

        if ( $request->has( 'query' ) ) {
            ( new DocumentKeywordSearch )( $documents, $request->get( 'query' ) );
        }

        if ( $request->has( 'start_date' ) || $request->has( 'end_date' ) ) {
            ( new DateSearch )( $documents, $request->only( [ 'start_date', 'end_date' ] ), 'document_date' );
        }

        $documents    = $documents->where( 'status', DocumentStatus::UNCONFIRMED )->paginate( 10 );
        $statuses     = DocumentStatus::lists();
        $current_user = auth()->user();

        return view( 'document.index', compact( 'documents', 'statuses', 'current_user' ) );

    }

    public function show( Document $document ) {
        $id         = $document->id;
        $currencies = Currency::all();
        $vendors    = Vendor::query()->where( 'creator_id', $document->user->id )->orWhere('creator_id', auth()->id())->get();
        $customers  = Customer::query()->where( 'creator_id', $document->user->id )->orWhere('creator_id', auth()->id())->get();
        $isPdf      = false;
        if ( $document->file ) {
            $isPdf = mime_content_type( $document->file ) == 'application/pdf';
        }
        $statuses       = DocumentStatus::lists();
        $creator        = $document->user;
        $expense_types  = ExpenseType::all();
        $income_types   = IncomeType::all();
        $document_types = $creator->organization_type->document_types;
        $current_user   = auth()->user();

        if ( $current_user->hasRole( 'Auditor' ) || $current_user->hasRole( 'Accountant' ) ) {
            $documents = $this->documentRepository->documentsAuditor()->get();
            $next      = $documents->where( 'id', '<', $id )->first();
            $prev      = $documents->where( 'id', '>', $id )->last();
        } else {
            $documents = Document::query()
                                 ->with( 'user' )
                                 ->where( 'user_id', '=', $current_user->id )
                                 ->orderByDesc( 'created_at' )
                                 ->get();
            $next      = $documents->where( 'id', '<', $id )->first();
            $prev      = $documents->where( 'id', '>', $id )->last();
        }

        return view( 'document.show', [
                                          'document'      => $document,
                                          'isPdf'         => $isPdf,
                                          'statuses'      => $statuses,
                                          'currencies'    => $currencies,
                                          'vendors'       => $vendors,
                                          'expense_types' => $expense_types
                                      ] + compact( 'prev', 'next', 'document_types', 'income_types', 'customers' ) );
    }

    public function upload() {
        return view( 'document.upload' );
    }

    public function store( Request $request ) {
        $request->validate( [
            'file' => 'required|file'
        ] );

        if ( $request->hasFile( 'file' ) ) {

            $filename = $request->file( 'file' )->getClientOriginalName();

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
            $date   = date( 'Y-m-d' );
            $file   = $request->file( 'file' )->store( "upload/documents/{$folder}/{$date}", 'public' );
            //}


            $document = Document::query()->create( [
                'user_id' => auth()->id(),
                'file'    => $file
            ] );


            ProcessDocument::dispatch( $file, $document );

            return redirect()->route( 'documents.index' )->withSuccess( __( 'Document uploaded successfully.' ) );
        }

        return redirect()->with( 'error', 'File is missing' );
    }

    public function create( ?User $client ) {
        $id             = $client->id ?? auth()->id();
        $currencies     = Currency::all();
        $vendors        = Vendor::query()->where( 'creator_id', $id )->orWhere('creator_id', auth()->id())->get();
        $customers      = Customer::query()->where( 'creator_id', $id )->orWhere('creator_id', auth()->id())->get();
        $expense_types  = ExpenseType::all();
        $income_types   = IncomeType::all();
        $document_types = $client->organization_type->document_types ?? auth()->user()->organization_type->document_types;
        $error_document = null;
        if ( session()->has( 'error_document_number' ) ) {
            $document = Document::query()->where( 'document_number', '=', session()->get( 'error_document_number' ) )->first();
            if ( $document ) {
                $error_document = route( 'documents.show', $document );
            }
        }
        $required = auth()->user()->hasRole( "Auditor" ) || auth()->user()->hasRole( "Accountant" );

        return view( 'document.create', compact( 'currencies', 'vendors', 'expense_types', 'document_types', 'income_types', 'customers', 'error_document', 'client', 'required' ) );
    }

    public function manualStore( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'document_number' => 'unique:documents|nullable',
            'sum'             => 'numeric|nullable',
            'vat'             => 'numeric|nullable',
            'file'            => 'file'
        ] );

        if ( $validator->fails() ) {
            $document = null;
            if ( $validator->errors()->has( 'document_number' ) ) {
                $document = $request->get( 'document_number' );
            }

            return redirect( route( 'document.create' ) )->withErrors( $validator )->withInput()->with( 'error_document_number', $document );
        }


        if ( $request->get( 'include_tax' ) == "on" ) {
            $vat = ( $request->sum / ( 1 + $request->vat / 100 ) ) * $request->vat / 100;
        } else {
            $vat = $request->sum * $request->vat / 100;
        }

        if ( $request->has( 'expense_type_id' ) ) {
            $expense_type = ExpenseType::find( $request->get( 'expense_type_id' ) );
            $vat          *= $expense_type->vat_rate->vat_rate ?? 1;
        }

        $sum_without_vat = $request->sum - $vat;

        $file = null;

        if ( $request->file ) {
            $folder = auth()->id();
            $date   = date( 'Y-m-d' );
            $file   = $request->file( 'file' )->store( "upload/documents/{$folder}/{$date}", 'public' );
        }

        $isExpense = $request->get( 'document_type' ) == 0;
        $isIncome  = $request->get( 'document_type' ) == 1;

        if ( $isExpense && ! $request->has( 'vendor_id' ) && $request->has( 'partner_vat' ) ) {
            $vendor = Vendor::create( [
                'vat_number' => $request->get( 'partner_vat' ),
                'creator_id' => $request->query( 'client' )
            ] );
        }

        if ( $isIncome && ! $request->has( 'customer_id' ) && $request->has( 'partner_vat' ) ) {
            $customer = Customer::create( [
                'vat_number' => $request->get( 'partner_vat' ),
                'creator_id' => $request->query( 'client' )
            ] );
        }

        Document::query()
                ->create( $request->except( [
                        'file',
                        'expense_type_id',
                        'income_type_id',
                        'customer_id',
                        'vendor_id',
                        'vat'
                    ] ) + [
                              'vat'             => $vat,
                              'file'            => $file,
                              'sum_without_vat' => $sum_without_vat,
                              'user_id'         => $request->query( 'client' ) ?? auth()->id(),
                              'vendor_id'       => $isExpense ? $vendor->id ?? $request->get( 'vendor_id' ) : null,
                              'customer_id'     => $isIncome ? $customer->id ?? $request->get( 'customer_id' ) : null,
                              'expense_type_id' => $isExpense ? $request->get( 'expense_type_id' ) : null,
                              'income_type_id'  => $isIncome ? $request->get( 'income_type_id' ) : null
                          ] );

        return redirect()->route( 'documents.index' )->withSuccess( __( 'Document created successfully' ) );
    }

    public function update( Request $request, Document $document ) {
        $sum_without_vat = $request->sum - $request->vat;

        $document->update( $request->all() + [
                'sum_without_vat' => $sum_without_vat,
                'vendor_id'       => $request->get( 'document_type' ) == 0 ? $request->get( 'vendor_id' ) : null,
                'customer_id'     => $request->get( 'document_type' ) == 1 ? $request->get( 'customer_id' ) : null,
                'expense_type_id' => $request->get( 'document_type' ) == 0 ? $request->get( 'expense_type_id' ) : null,
                'income_type_id'  => $request->get( 'document_type' ) == 1 ? $request->get( 'income_type_id' ) : null
            ] );

        return redirect()->route( 'documents.show', $document )->withSuccess( __( 'Document updated successfully.' ) );
    }

    public function destroy( Document $document ) {
        if ( $document->file ) {
            Storage::disk( 'public' )->delete( $document->file );
        }
        $document->delete();

        return redirect()->back()->withSuccess( __( "Document deleted successfully" ) );
    }

    public function restore( int $id ) {
        $document = Document::onlyTrashed()->findOrFail( $id );
        $document->restore();

        return redirect()->back()->withSuccess( __( "Document restored successfully" ) );
    }

    public function lastModified( Request $request ) {
        $documents = $this->documentRepository->lastModifiedDocuments();

        if ( $request->has( 'start_date' ) || $request->has( 'end_date' ) ) {
            ( new MonthFilter )( $documents, $request->only( [ 'start_date', 'end_date' ] ), 'document_date' );
        }

        $documents = $documents->paginate();

        return view( 'document.last', compact( 'documents' ) );
    }

    public function duplicate( Document $document ) {
        $newDocument                  = $document->replicate();
        $newDocument->document_number = "";
        $newDocument->status          = DocumentStatus::UNCONFIRMED;
        $newDocument->save();

        return redirect()->back()->withSuccess( __( 'Document duplicated successfully!' ) );
    }
}
