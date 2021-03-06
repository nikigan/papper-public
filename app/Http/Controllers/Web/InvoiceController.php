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
use Vanguard\IncomeType;
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
        $invoices = Invoice::query()->where('creator_id', $current_user->id)->orderByDesc('created_at')->paginate(10);
        return view('invoices.index', compact('invoices',));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $id = Invoice::query()->withTrashed()->orderByDesc('id')->first()->id + 1;
        $tax = 17;
        $user = auth()->user();
        $organization_type = $user->organization_type;
        $document_types = $organization_type->document_types;
        $currencies = Currency::all();
        $customers = Customer::query()->where('creator_id', $user->id)->get();
        $payment_types = PaymentType::all();
        $income_types = IncomeType::all();
        $have_tax = $organization_type->have_tax;

        return view('invoices.create', compact('tax', 'user', 'customers', 'id', 'document_types', 'currencies', 'payment_types', 'have_tax', 'income_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $prefix = DocumentType::query()->find($request->get('invoice')['document_type'])->prefix;

        $request->merge([
            'invoice[invoice_number]' => $prefix . $request->get('invoice')['invoice_number'],
        ]);
        $tax = isset($request->get('invoice')['include_tax']) ? 1 : 0;

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

        $invoice = Invoice::query()->create($request->except('invoice.invoice_number', 'invoice.include_tax')['invoice'] + [
                'include_tax' => $tax,
                'invoice_number' => $request->get('invoice[invoice_number]'),
                'creator_id' => auth()->id(),
                'note' => $request->get('note')
            ]);

        for ($i = 0; $i < count($request->service); $i++) {
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
        $document_name = $invoice->dt->name;
        $currency = $invoice->currency;
        $have_tax = $invoice->creator->organization_type->have_tax;
        $tax_k = $invoice->include_tax ? 1 : -1;
        return view('invoices.show', compact('invoice', 'document_name', 'currency', 'tax_k', 'have_tax'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    /* public function edit($id)
     {
         //
     }*/

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
        return redirect()->back()->with('success', __('Invoice deleted successfully'));
    }

    public function restore( int $id ) {
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->restore();

        return redirect()->back()->withSuccess(__("Invoice restored successfully"));
    }

    public function download(Invoice $invoice)
    {
        $document_name = $invoice->dt->name;
        $currency = $invoice->currency;
        $have_tax = $invoice->creator->organization_type->have_tax;
        $tax_k = $invoice->include_tax ? 1 : -1;
        $pdf = \SPDF::loadView('invoices.pdf', compact('invoice', 'document_name', 'currency', 'have_tax', 'tax_k'));
        return $pdf->download("{$document_name}-{$invoice->invoice_number}.pdf");
    }
}
