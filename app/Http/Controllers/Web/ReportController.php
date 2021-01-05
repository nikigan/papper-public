<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\DocumentType;
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

        $expenses_columns = [
            [
                'name' => 'document_date',
                'title' => 'Date'
            ],
            [
                'name' => 'document_number',
                'title' => 'Number'
            ],
            [
                'name' => 'sum',
                'title' => 'Sum'
            ],
            [
                'name' => 'vat',
                'title' => 'VAT'
            ],
        ];

        $incomes = $client->documents()->where('document_type', '=', 1);

        $income_columns = [
            [
                'name' => 'document_date',
                'title' => 'Date'
            ],
            [
                'name' => 'document_number',
                'title' => 'Number'
            ],
            [
                'name' => 'sum',
                'title' => 'Sum'
            ],
            [
                'name' => 'vat',
                'title' => 'VAT'
            ],
            [
                'name' => 'document_type[
                \'name\']',
                'title' => 'Type'
            ]
        ];


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

        $incomes = $incomes->merge($invoices);
        $incomes_without_vat = $incomes->where('vat', '<>', 0);


        return view('reports.report1', compact('expenses', 'invoices', 'incomes', 'expenses_columns', 'income_columns', 'client'));
    }
}
