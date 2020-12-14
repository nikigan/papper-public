<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Vanguard\Customer;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\InvoicesItem;

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
        $tax = 0;
        $user = auth()->user();
        $customers = Customer::query()->where('creator_id', $user->id)->get();

        return view('invoices.create', compact('tax', 'user', 'customers', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice[invoice_number]' => 'unique:invoices'
        ]);

        $invoice = Invoice::query()->create($request->invoice + [
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
        return view('invoices.show', compact('invoice'));
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download(Invoice $invoice)
    {

    }
}
