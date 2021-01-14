<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class Reports extends Plugin
{
    public function sidebar()
    {
        $client = \Route::current()->parameter('client');
        if ($client) {
            $report1 = Item::create(__('Report 1'))
                ->permissions('reports.report1')
                ->href(route('reports.report1.index', $client));

            $report2 = Item::create(__('Report 2'))
                ->permissions('reports.report2')
                ->href(route('reports.report2.index', $client));

            $report3 = Item::create(__('Report 3'))
                ->permissions('reports.report3')
                ->href(route('reports.report3.index', $client));

            $report_vendors = Item::create(__('Report') . ' ' . __('Vendors'))
                ->permissions('reports.report_vendors')
                ->href(route('reports.report_vendors.index', $client));

            $report_customers = Item::create(__('Report') . ' ' . __('Customers'))
                ->permissions('reports.report_customers')
                ->href(route('reports.report_customers.index', $client));

            $report_tax = Item::create(__('Report Tax'))
                ->permissions('reports.report_tax')
                ->href(route('reports.report_tax.index', $client));

            return Item::create(__('Reports'))
                ->href('#reports-dropdown')
                ->icon('fas fa-document')
                ->permissions(['reports.general'])
                ->addChildren([
                    $report1,
                    $report2,
                    $report3,
                    $report_vendors,
                    $report_customers,
                    $report_tax
                ]);
        } else {
            return false;
        }
    }
}
