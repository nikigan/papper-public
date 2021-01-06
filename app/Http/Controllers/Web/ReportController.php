<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\DocumentType;
use Vanguard\ExpenseType;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\User;

class ReportController extends Controller
{
    public function report1(Request $request, User $client)
    {

        $start_date = $request->get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-1 month"));
        $end_date = $request->get('end_date') ?? date('Y-m-d');

        $expenses = $client->documents()->where('document_type', '=', 0)->orderByDesc('document_date')->where('status', DocumentStatus::CONFIRMED);

        $incomes = $client->documents()->where('document_type', '=', 1)->orderByDesc('document_date')->where('status', DocumentStatus::CONFIRMED);

        $invoices = $client->invoices();


        if ($end_date) {
            $expenses = $expenses->where('document_date', '<=', $end_date);
            $incomes = $incomes->where('document_date', '<=', $end_date);
            $invoices = $invoices->where('invoice_date', '<=', $end_date);
        }

        if ($start_date) {
            $expenses = $expenses->where('document_date', '>=', $start_date);
            $incomes = $incomes->where('document_date', '>=', $start_date);
            $invoices = $invoices->where('invoice_date', '>=', $start_date);
        }

        $expenses = $expenses->get();
        $incomes = $incomes->get();

        $invoices = $invoices->get();

        $incomes_with_vat = $incomes->where('vat', '<>', 0)->where('document_type_id', '<>', 3);
        $incomes_without_vat = $incomes->where('vat', '=', 0)->where('document_type_id', '<>', 3);

        $invoices_without_vat = $invoices->where('tax_percent', '=', 0)->where('document_type', '<>', 3);
        $invoices_with_vat = $invoices->where('tax_percent', '<>', 0)->where('document_type', '<>', 3);

        $acceptances = $invoices->where('document_type', '=', 3);
        $document_acceptances = $incomes->where('document_type_id', '=', 3);

        return view('reports.report1', compact('expenses', 'invoices', 'incomes', 'client', 'incomes_with_vat', 'incomes_without_vat', 'invoices_with_vat', 'invoices_without_vat', 'acceptances', 'document_acceptances'));
    }

    public function report2 (Request $request, User $client) {
        $start_date = $request->get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-1 month"));
        $end_date = $request->get('end_date') ?? date('Y-m-d');

        $expenses = $client->documents()->with('expense_type')->where('document_type', '=', 0)->orderByDesc('document_date')->where('status', DocumentStatus::CONFIRMED);

        if ($end_date) {
            $expenses = $expenses->where('document_date', '<=', $end_date);
        }

        if ($start_date) {
            $expenses = $expenses->where('document_date', '>=', $start_date);
        }

        $expense_groups = $expenses->get()->groupBy('expense_type.name');

        return view('reports.report2', compact('expense_groups', 'client'));

    }
}
