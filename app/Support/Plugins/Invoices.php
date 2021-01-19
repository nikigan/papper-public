<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Invoices extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Invoices'))
            ->route('invoice.index')
            ->permissions('invoices.manage')
            ->icon('fas fa-file-alt')
            ->active("invoice*");
    }
}
