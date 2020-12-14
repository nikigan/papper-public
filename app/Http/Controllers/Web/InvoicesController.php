<?php

namespace Vanguard\Http\Controllers;

use Vanguard\Customer;
use Vanguard\CustomersField;
use Vanguard\Invoice;
use Vanguard\InvoicesItem;
use Vanguard\Product;
use Illuminate\Http\Request;
use Mpociot\VatCalculator\Facades\VatCalculator;

class InvoicesController extends Controller
{

    public function create(Request $request)
    {
        $user = User::find($request->user_id);
        return view('invoices.create', compact('user'));
    }

    public function store(Request $request)
    {
        $invoice = Invoice::create($request->invoice);
        for ($i=0; $i < count($request->product); $i++) {
            if (isset($request->qty[$i]) && isset($request->price[$i])) {
                InvoicesItem::create([
                    'invoice_id' => $invoice->id,
                    'name' => $request->product[$i],
                    'quantity' => $request->qty[$i],
                    'price' => $request->price[$i]
                ]);
            }
        }

        return redirect()->route('home');
    }

    public function show($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        return view('invoices.show', compact('invoice'));
    }

    public function download($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $pdf     = \PDF::loadView('invoices.pdf', compact('invoice'));

        return $pdf->stream('invoice.pdf');
    }

}
