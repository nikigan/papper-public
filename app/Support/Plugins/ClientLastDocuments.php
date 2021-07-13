<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientLastDocuments extends Plugin
{
    public function sidebar()
    {
        $client = \Route::current()->parameter('client');

        if ($client) {
            return Item::create(__('Client\'s Last Documents'))
                ->href(route('clients.last', ['client' => $client]))
                ->permissions('clients.manage');
        } else {
            return false;
        }
    }
}
