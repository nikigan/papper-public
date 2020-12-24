<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Search extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Search'))
            ->route('search.index')
            ->icon('fas fa-search')
            ->active("search")
            ->permissions('search');
    }
}
