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

            return Item::create(__('Reports'))
                ->href('#reports-dropdown')
                ->icon('fas fa-document')
                ->permissions(['reports.general'])
                ->addChildren([
                    $report1,
                ]);
        } else {
            return false;
        }
    }
}
