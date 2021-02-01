<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class Vendors extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Vendors'))
            ->route('vendors.index')
            ->permissions(function (User $user) {
                return $user->hasRole('Client');
            })
            ->icon('fas fa-user-tag')
            ->active("vendors*");
    }
}
