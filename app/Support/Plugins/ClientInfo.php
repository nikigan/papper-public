<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientInfo extends Plugin
{
    public function sidebar()
    {
        $client = \Route::current()->parameter('client');

        if ($client) {
            return Item::create(__('Client\'s Info'))
                ->href(route('clients.info', $client))
                ->permissions('clients.manage');
        } else {
            return false;
        }
    }
}
