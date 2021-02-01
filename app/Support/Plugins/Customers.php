<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class Customers extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Customers'))
            ->route('customers.index')
            ->permissions(function (User $user) {
                return $user->hasRole('Client');
            })
            ->icon('fas fa-id-badge')
            ->active("customers*");
    }
}
