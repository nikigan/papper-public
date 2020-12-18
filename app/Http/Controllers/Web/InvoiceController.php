<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Vanguard\Currency;
use Vanguard\Customer;
use Vanguard\DocumentType;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\InvoicesItem;
use Vanguard\PaymentType;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|View
     */
    public function index()
    {
        $current_user = auth()->user();
        $invoices = Invoice::query()->where('creator_id', $current_user->id)->paginate(10);
        return view('invoices.index', compact('invoices',));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $statement = DB::select("SHOW TABLE STATUS LIKE 'invoices'");
        $id = $statement[0]->Auto_increment;
        $tax = 17;
        $user = auth()->user();
        $organization_type = $user->organization_type;
        $document_types = $organization_type->document_types;
        $currencies = Currency::all();
        $customers = Customer::query()->where('creator_id', $user->id)->get();
        $payment_types = PaymentType::all();
        $have_tax = $organization_type->have_tax;

        return view('invoices.create', compact('tax', 'user', 'customers', 'id', 'document_types', 'currencies', 'payment_types', 'have_tax'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $prefix = DocumentType::query()->find($request->get('invoice')['document_type'])->prefix;

        $request->merge([
            'invoice[invoice_number]' => $prefix . $request->get('invoice')['invoice_number']
        ]);

        $request->validate([
            'invoice[invoice_number]' => 'unique:invoices,invoice_number',
            'invoice.invoice_date' => 'before_or_equal:today',
            'invoice.customer_id' => 'required'

        ]);

        /*dd($request->except('invoice.invoice_number')['invoice'] + [
                'invoice_number' => $request->get('invoice[invoice_number]'),
                'creator_id' => auth()->id()
            ]);*/
        /*dd($request->except('invoice.invoice_number')['invoice'] + [
        'invoice_number' => $request->get('invoice[invoice_number]'),
        'creator_id' => auth()->id()
    ]);*/
        $invoice = Invoice::query()->create($request->except('invoice.invoice_number')['invoice'] + [
            'invoice_number' => $request->get('invoice[invoice_number]'),
            'creator_id' => auth()->id()
            ]);

        for ($i=0; $i < count($request->service); $i++) {
            if (isset($request->qty[$i]) && isset($request->price[$i])) {
                InvoicesItem::create([
                    'invoice_id' => $invoice->id,
                    'name' => $request->service[$i],
                    'quantity' => $request->qty[$i],
                    'price' => $request->price[$i]
                ]);
            }
        }

        return redirect()->route('invoice.index');
    }

    /**
     * Display the specified resource.
     * @param Invoice $invoice
     * @return View
     */
    public function show(Invoice $invoice)
    {
        $document_name = $invoice->document_type()->first()->name;
        $currency = $invoice->currency;
        $have_tax = auth()->user()->organization_type->have_tax;
        $tax_k = $invoice->include_tax ? 1 : -1;
        return view('invoices.show', compact('invoice', 'document_name', 'currency', 'tax_k', 'have_tax'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function edit($id)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {
        //
    }*/

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->back()-with('success', __('Invoice deleted successfully'));
    }

    public function download(Invoice $invoice)
    {
        $document_name = $invoice->document_type()->first()->name;
        $currency = $invoice->currency;
        $have_tax = auth()->user()->organization_type->have_tax;
        $tax_k = $invoice->include_tax ? 1 : -1;
        $pdf = \PDF::loadView('invoices.pdf', compact('invoice', 'document_name', 'currency', 'have_tax', 'tax_k'));
        return Response::streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "{$document_name}-{$invoice->invoice_number}.pdf");
    }
}
