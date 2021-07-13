<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ClientDocuments extends Plugin
{
    public function sidebar()
    {
        $client = \Route::current()->parameter('client');

        if ($client) {
            return Item::create(__('Client\'s Documents'))
                ->href(route('clients.documents', ['client' => $client]))
                ->permissions('clients.manage');
        } else {
            return false;
        }
    }
}
