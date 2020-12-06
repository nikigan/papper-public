<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Accountants extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Accountants'))
            ->route('accountants.index')
            ->icon('fas fa-user-tie')
            ->active("accountants")
            ->permissions('client.assign');
    }
}
