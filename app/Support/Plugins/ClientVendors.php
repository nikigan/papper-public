<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientVendors extends Plugin
{
    public function sidebar()
    {
        $client = \Route::current()->parameter('client');

        if ($client) {
            return Item::create(__('Client\'s Vendors'))
                ->href(route('clients.vendors', $client))
                ->permissions('clients.manage');
        } else {
            return false;
        }
    }
}
