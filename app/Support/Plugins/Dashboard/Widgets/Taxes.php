<?php

namespace Vanguard\Support\Plugins\Dashboard\Widgets;

use Illuminate\Support\Facades\DB;
use Vanguard\Http\Filters\DateSearch;
use Vanguard\Plugins\Widget;
use Vanguard\Repositories\Document\DocumentRepository;
use Vanguard\Support\Enum\DocumentStatus;
use Vanguard\User;

class Taxes extends Widget
{
    /**
     * {@inheritdoc}
     */
    public $width = '4';

    /**
     * {@inheritdoc}
     */
    protected $permissions = [];

    /**
     * @var DocumentRepository
     */
    private DocumentRepository $documents;

    /**
     * TotalUsers constructor.
     * @param DocumentRepository $documents
     */
    public function __construct(DocumentRepository $documents)
    {
        $this->documents = $documents;
        $this->permissions = function (User $user) {
            return $user->hasRole('User');
        };
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $client = auth()->user();

        $start_date = date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"));
        $end_date = date('Y-m-d');

        $income = $client->documents()->where('status', DocumentStatus::CONFIRMED)->getQuery();

        (new DateSearch)($income, compact('start_date', 'end_date'), 'document_date');

        $document_vat = $income->leftJoin('currencies as c', 'documents.currency_id', '=', 'c.id')->select(DB::raw('SUM(vat/c.value) as vat, SUM(sum/c.value) as sum, document_type'))->groupBy('document_type')->get()->toArray();

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

        if (!isset($document_vat[1])) {
            $document_vat[1] = [
                'vat' => 0,
                'sum' => 0
            ];
        }
        if (!isset($document_vat[0])) {
            $document_vat[0] = [
                'vat' => 0,
                'sum' => 0
            ];
        }

        $in_vat = $document_vat[1]['vat'] + $invoices_vat->sum('vat');
        $exp_vat = $document_vat[0]['vat'];
        $diff_vat = $in_vat - $exp_vat;
/*
        $in_vat = number_format($in_vat, 2);
        $exp_vat = number_format($exp_vat, 2);*/
        $diff_vat = number_format($diff_vat, 2);

        $in_sum = $document_vat[1]['sum'] + $invoices_vat->sum('sum');
        $in_tax = $in_sum * $client->tax_percent / 100;

//        $in_sum = number_format($in_sum, 2);
        $in_tax = number_format($in_tax, 2);

        return view('plugins.dashboard.widgets.taxes', compact('diff_vat', 'in_tax', 'client'));
    }
}
