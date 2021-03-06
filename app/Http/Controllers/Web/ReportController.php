<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Vanguard\Document;
use Vanguard\Exports\ExcelReport;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Filters\DateSearch;
use Vanguard\IncomeGroup;
use Vanguard\Invoice;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\User;

class ReportController extends Controller
{

    private function report1_data(Request $request, User $client): array
    {
        $start_date = $request->get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"));
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


        return compact('expenses', 'invoices', 'incomes', 'client', 'incomes_with_vat', 'incomes_without_vat', 'invoices_with_vat', 'invoices_without_vat', 'acceptances', 'document_acceptances');
    }

    public function report1(Request $request, User $client)
    {
        $data = $this->report1_data($request, $client);

        return view('reports.report1', $data);
    }

    public function report1_excel(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report1_data($request, $client);
        return Excel::download(new ExcelReport($data, 'reports.excel.report1'), "report1-{$client->present()->name}-{$date}.xlsx");
    }

    public function report1_pdf(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report1_data($request, $client);

        $pdf = \PDF::loadView('reports.excel.report1', $data);

        return $pdf->download("report1-{$client->present()->name}-{$date}.pdf");
    }

    private function report2_data(Request $request, User $client): array
    {
        $start_date = $request->get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"));
        $end_date = $request->get('end_date') ?? date('Y-m-d');

        $expenses = $client->documents()->with('expense_type')->where('document_type', '=', 0)->orderByDesc('document_date')->where('status', DocumentStatus::CONFIRMED);

        $incomes = $client->documents()->where('document_type', '=', 1)->orderByDesc('document_date')->where('status', DocumentStatus::CONFIRMED)->with('income_type');

        $invoices = $client->invoices()->with('income_type')->orderByDesc('invoice_date');

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

        $expense_groups = $expenses->get()->groupBy('expense_type.name');
        $income_groups = $incomes->get()->groupBy('income_type.name');
        $invoices_groups = $invoices->get()->groupBy('income_type.name');


        $income_groups = $income_groups->mergeRecursive($invoices_groups);

        return compact('expense_groups', 'client', 'income_groups');
    }

    public function report2(Request $request, User $client)
    {
        $data = $this->report2_data($request, $client);
        return view('reports.report2', $data);
    }

    public function report2_excel(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report2_data($request, $client);
        return Excel::download(new ExcelReport($data, 'reports.excel.report2'), "report2-{$client->present()->name}-{$date}.xlsx");
    }

    public function report2_pdf(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report2_data($request, $client);

        $pdf = \PDF::loadView('reports.excel.report2', $data);

        return $pdf->download("report2-{$client->present()->name}-{$date}.pdf");

    }

    private function report3_data(Request $request, User $client)
    {
        $start_date = $request->get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"));
        $end_date = $request->get('end_date') ?? date('Y-m-d');

        $income_groups = $client->documents()->where('document_type', '=', 1)->where('status', DocumentStatus::CONFIRMED)->getQuery();

        (new DateSearch)($income_groups, compact('end_date', 'start_date'), 'document_date');

        $income_groups = $income_groups->leftJoin('currencies as c', 'documents.currency_id', '=', 'c.id')->leftJoin('income_types as it', 'documents.income_type_id', '=', 'it.id')->leftJoin('income_groups as ig', 'it.income_group_id', '=', 'ig.id')->select('ig.name', 'ig.id as group_id', 'it.name', DB::raw('SUM(documents.sum / c.value) as sum'))->groupBy('it.name', 'ig.name')->get();

        $income_groups = $income_groups->groupBy('group_id');


        $invoice_groups = $client->invoices()->with('income_type')->getQuery();

        (new DateSearch)($invoice_groups, compact('end_date', 'start_date'), 'invoice_date');

        $invoice_groups = $invoice_groups->leftJoin('currencies as c', 'invoices.currency_id', '=', 'c.id')->select('ig.name', 'ig.id as group_id', 'it.name', DB::raw('sum(ii.price*ii.quantity / c.value) as sum'), DB::raw('sum((IF(invoices.include_tax = 1, -1, 1)) * ii.price * ii.quantity * invoices.tax_percent / 100 / c.value) as vat'))->leftJoin('invoices_items as ii', 'invoices.id', '=', 'ii.invoice_id')->leftJoin('income_types as it', 'invoices.income_type_id', '=', 'it.id')->leftJoin('income_groups as ig', 'it.income_group_id', '=', 'ig.id')->groupBy('ig.name', 'it.name')->get();

        $invoice_groups = $invoice_groups->groupBy('group_id');

        foreach ($invoice_groups as $key => $group) {
            $ig = IncomeGroup::query()->find($key);
            if ($ig) {
                $invoice_groups[$ig->name] = $invoice_groups[$key];
                unset($invoice_groups[$key]);
            }
        }

        foreach ($income_groups as $key => $value) {

            $ig = IncomeGroup::query()->find($key);
            if ($ig) {
                $income_groups[$ig->name] = $income_groups[$key];
                unset($income_groups[$key]);
            }
        }

        $income_groups = $income_groups->mergeRecursive($invoice_groups);

        $groups = [];
        $income_sum = 0;
        foreach ($income_groups as $name => $group) {
            foreach ($group as $item) {
                if ($item instanceof Document || $item instanceof Invoice) {
                    $groups['Other Income Group']['subgroups']['Other']['sum'] = ($groups[$name]['subgroups']['Other']['sum'] ?? 0) + $item->sum;
                    $groups['Other Income Group']['sum'] = ($groups['Other Income Group']['sum'] ?? 0) + $item->sum;
                    $income_sum += $item->sum;
                }
                if (is_array($item)) {
                    foreach ($item as $i) {
                        $groups[$name]['subgroups'][$i->name]['sum'] = ($groups[$name]['subgroups'][$i->name]['sum'] ?? 0) + $i->sum;
                        $groups[$name]['sum'] = ($groups[$name]['sum'] ?? 0) + $i->sum;
                        $income_sum += $i->sum;

                    }
                }
            }
        }

        foreach ($groups as $k => $group) {
            foreach ($group['subgroups'] as $key => $subgroup) {
                if ($group['sum']) {
                    $groups[$k]['subgroups'][$key]['percentage'] = $subgroup['sum'] / $group['sum'] * 100;
                } else {
                    $groups[$k]['subgroups'][$key]['percentage'] = 0;
                }
            }
        }


        $expense_groups = $client->documents()->where('document_type', '=', 0)->where('status', DocumentStatus::CONFIRMED)->getQuery();

        (new DateSearch)($expense_groups, compact('end_date', 'start_date'), 'document_date');

        $expense_groups = $expense_groups->leftJoin('currencies as c', 'documents.currency_id', '=', 'c.id')->select('eg.name as group', 'et.name as name', DB::raw('SUM(documents.sum / c.value) as sum'))->leftJoin('expense_types as et', 'documents.expense_type_id', '=', 'et.id')->leftJoin('expense_groups as eg', 'et.expense_group_id', '=', 'eg.id')->groupBy(['group', 'name'])->get()->groupBy(['group', 'name'])->toArray();

        $expense_sum = 0;

        foreach ($expense_groups as $key => $expense_group) {
            $sum = 0;
            foreach ($expense_group as $subgroup) {
                $sum += $subgroup[0]['sum'];
            }
            $expense_groups[$key]['sum'] = $sum;
            $expense_sum += $sum;
        }

        foreach ($expense_groups as $k => $expense_group) {
            foreach ($expense_group as $key => $subgroup) {
                if ($key != 'sum')
                    $expense_groups[$k][$key][0]['percentage'] = $subgroup[0]['sum'] / $expense_groups[$k]['sum'] * 100;
            }
        }

        $diff = $income_sum - $expense_sum;

        return compact('client', 'groups', 'expense_groups', 'income_sum', 'expense_sum', 'diff', 'start_date', 'end_date');
    }

    public function report3(Request $request, User $client)
    {
        $data = $this->report3_data($request, $client);
        return view('reports.report3', $data);
    }

    public function report3_excel(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report3_data($request, $client);
        $data['percentage'] = $request->get('percentage') === "on";
        return Excel::download(new ExcelReport($data, 'reports.excel.report3'), "report3-{$client->present()->name}-{$date}.xlsx");
    }

    public function report3_pdf(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report3_data($request, $client);
        $data['percentage'] = $request->get('percentage') === "on";

        $pdf = \PDF::loadView('reports.excel.report3', $data);

        return $pdf->download("report3-{$client->present()->name}-{$date}.pdf");
    }

    private function report_vendors_data(Request $request, User $client): array
    {
        $start_date = $request->get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"));
        $end_date = $request->get('end_date') ?? date('Y-m-d');

        $expenses = $client->documents()->where('document_type', '=', 0)->where('status', DocumentStatus::CONFIRMED)->getQuery();

        (new DateSearch)($expenses, compact('end_date', 'start_date'), 'document_date');

        $vendor_groups = $expenses->leftJoin('currencies as c', 'documents.currency_id', '=', 'c.id')->leftJoin('vendors as v', 'documents.vendor_id', '=', 'v.id')->groupBy(['v.name', 'v.vat_number'])->select('v.name', 'v.vat_number', DB::raw('count(*) as amount'), DB::raw('sum(documents.sum / c.value) as sum'), DB::raw('AVG(sum) as avg'))->get();

        return compact('client', 'vendor_groups');
    }

    public function report_vendors(Request $request, User $client)
    {
        $data = $this->report_vendors_data($request, $client);
        return view('reports.report_vendors', $data);
    }

    public function report_vendors_excel(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report_vendors_data($request, $client);
        return Excel::download(new ExcelReport($data, 'reports.excel.report_vendors'), "report_vendors-{$client->present()->name}-{$date}.xlsx");
    }

    public function report_vendors_pdf(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report_vendors_data($request, $client);

        $pdf = \PDF::loadView('reports.excel.report_vendors', $data);

        return $pdf->download("report_vendors-{$client->present()->name}-{$date}.pdf");
    }

    private function report_customers_data(Request $request, User $client)
    {
        $start_date = $request->get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"));
        $end_date = $request->get('end_date') ?? date('Y-m-d');

        $income_groups = $client->documents()->where('document_type', '=', 1)->where('status', DocumentStatus::CONFIRMED)->getQuery();

        (new DateSearch)($income_groups, compact('end_date', 'start_date'), 'document_date');

        $income_customers = $income_groups->leftJoin('currencies as c', 'documents.currency_id', '=', 'c.id')->leftJoin('customers as cu', 'documents.customer_id', '=', 'cu.id')->groupBy(['cu.name', 'cu.vat_number'])->select('cu.name', 'cu.vat_number', DB::raw('count(*) as amount'), DB::raw('sum(documents.sum / c.value) as sum'), DB::raw('AVG(sum) as avg'))->get()->groupBy(['name'])->toArray();

        $invoice_customers = $client->invoices()->getQuery();

        (new DateSearch)($invoice_customers, compact('end_date', 'start_date'), 'invoice_date');

        $invoice_customers = $invoice_customers->leftJoin('currencies as c', 'invoices.currency_id', '=', 'c.id')->leftJoin('customers as cu', 'invoices.customer_id', '=', 'cu.id')->groupBy(['cu.name', 'cu.vat_number'])->leftJoin('invoices_items as ii', 'invoices.id', '=', 'ii.invoice_id')->select('cu.name', 'cu.vat_number', DB::raw('count(*) as amount'), DB::raw('sum(ii.price*ii.quantity / c.value) as sum'))->get()->groupBy(['name'])->toArray();

        $customers = array_merge_recursive($invoice_customers, $income_customers);

        $result = [];
        foreach ($customers as $name => $customer) {
            foreach ($customer as $item) {
                $result[$name]['name'] = $item['name'];
                $result[$name]['vat_number'] = $item['vat_number'];
                $result[$name]['sum'] = ($result[$name]['sum'] ?? 0) + $item['sum'];
                $result[$name]['amount'] = ($result[$name]['amount'] ?? 0) + $item['amount'];

            }
        }

        foreach ($customers as $name => $customer) {
            $result[$name]['avg'] = $result[$name]['sum'] / $result[$name]['amount'];
        }

        return ['customers' => $result, 'client' => $client];
    }

    public function report_customers(Request $request, User $client)
    {
        $data = $this->report_customers_data($request, $client);
        return view('reports.report_customers', $data);
    }

    public function report_customers_excel(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report_customers_data($request, $client);
        return Excel::download(new ExcelReport($data, 'reports.excel.report_customers'), "report_customers-{$client->present()->name}-{$date}.xlsx");
    }

    public function report_customers_pdf(Request $request, User $client)
    {
        $date = date('Y-m-d');
        $data = $this->report_customers_data($request, $client);

        $pdf = \PDF::loadView('reports.excel.report_customers', $data);

        return $pdf->download("report_customers-{$client->present()->name}-{$date}.pdf");

    }



    public function report_tax(Request $request, User $client)
    {
        $start_date = $request->get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"));
        $end_date = $request->get('end_date') ?? date('Y-m-d');

        $income = $client->documents()->where('status', DocumentStatus::CONFIRMED)->getQuery();

        (new DateSearch)($income, compact('start_date', 'end_date'), 'document_date');

        $document_vat = $income->leftJoin('currencies as c', 'documents.currency_id', '=', 'c.id')->select(DB::raw('SUM(vat/c.value) as vat, SUM(sum/c.value) as sum, document_type'))->groupBy('document_type')->get()->toArray();

        $equipment_vat = $income->leftJoin('currencies as cur', 'documents.currency_id', '=', 'cur.id')->select(DB::raw("SUM(vat/cur.value) as vat, SUM(sum/cur.value) as sum, expense_type_id"))->groupBy('expense_type_id')->where('expense_type_id', 700)->get();

        $invoices = $client->invoices()->getQuery();

        (new DateSearch())($invoices, compact('start_date', 'end_date'), 'invoice_date');

        $invoices_vat = $invoices->leftJoin('currencies as c', 'invoices.currency_id', '=', 'c.id')->leftJoin('invoices_items as ii', 'invoices.id', 'ii.invoice_id')->select(DB::raw('sum(ii.price*ii.quantity / c.value) as sum'), DB::raw('sum(ii.price*ii.quantity / c.value) * invoices.tax_percent / 100 as vat'), 'invoices.id')->groupBy('invoices.id')->get();

        if (!count($document_vat)) {
            $document_vat = [
                0 => [
                    'vat' => 0,
                    'sum' => 0
                ],
                1 => [
                    'vat' => 0,
                    'sum' => 0
                ]
            ];
        }

        if (!isset($document_vat[0])) {
            $document_vat[0] = [
                    'vat' => 0,
                    'sum' => 0];
        }


        if (!isset($document_vat[1])) {
            $document_vat[1] = [
                    'vat' => 0,
                    'sum' => 0];
        }

        $in_vat = $document_vat[1]['vat'] + $invoices_vat->sum('vat');
        $exp_vat = $document_vat[0]['vat'];
        $diff_vat = $in_vat - $exp_vat;

        $in_vat = number_format($in_vat, 2);
        $exp_vat = number_format($exp_vat, 2);
        $diff_vat = number_format($diff_vat, 2);
        $equipment_vat = number_format($equipment_vat->sum('vat'), 2);

        $in_sum = $document_vat[1]['sum'] + $invoices_vat->sum('sum');
        $in_tax = $in_sum * $client->tax_percent / 100;

        $in_sum = number_format($in_sum, 2);
        $in_tax = number_format($in_tax, 2);


        return view('reports.report_tax', compact('in_vat', 'exp_vat', 'diff_vat', 'client', 'in_tax', 'in_sum', 'equipment_vat'));
    }
}
