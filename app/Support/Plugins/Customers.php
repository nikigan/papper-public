<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Customers extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Customers'))
            ->route('customers.index')
            ->permissions('customers.manage')
            ->icon('fas fa-id-badge')
            ->active("customers*");
    }
}
