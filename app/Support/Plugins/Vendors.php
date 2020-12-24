<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Vendors extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Vendors'))
            ->route('vendors.index')
            ->permissions('vendors.manage')
            ->icon('fas fa-user-tag')
            ->active("vendors*");
    }
}
