<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientCustomers extends Plugin
{
    public function sidebar()
    {
        $client = \Route::current()->parameter('client');

        if ($client) {
            return Item::create(__('Client\'s Customers'))
                ->href(route('clients.customers', ['client' => $client]))
                ->permissions('clients.manage');
        } else {
            return false;
        }
    }
}
