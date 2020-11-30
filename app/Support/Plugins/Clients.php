<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Clients extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Clients'))
            ->route('clients.index')
            ->icon('fas fa-user-tie')
            ->active("clients")
            ->permissions('clients.manage');
    }
}
