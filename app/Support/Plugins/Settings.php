<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class Settings extends Plugin
{
    public function sidebar()
    {
        $general = Item::create(__('General'))
            ->route('settings.general')
            ->active("settings")
            ->permissions('settings.general');

        $authAndRegistration = Item::create(__('Auth & Registration'))
            ->route('settings.auth')
            ->active("settings/auth")
            ->permissions('settings.auth');

        $notifications = Item::create(__('Notifications'))
            ->route('settings.notifications')
            ->active("settings/notifications")
            ->permissions(function (User $user) {
                return $user->hasPermission('settings.notifications');
            });

        $document_types = Item::create(__('Document Types'))
            ->route('document_types.index')
            ->active('document_types')
            ->permissions(function (User $user) {
                return $user->hasRole('Admin');
            });

        $currencies = Item::create(__('Currencies'))
            ->route('currency.index')
            ->active('currency')
            ->permissions(function (User $user) {
                return $user->hasRole('Admin');
            });

        $payment_types = Item::create(__('Payment types'))
            ->route('payment_types.index')
            ->active('payment_types')
            ->permissions(function (User $user) {
                return $user->hasRole('Admin');
            });

        $organization_types = Item::create(__('Organization types'))
            ->route('organization_types.index')
            ->permissions(function (User $user) {
                return $user->hasRole('Admin');
            });

        $expense_types = Item::create(__('Expense types'))
            ->route('expense_types.index')
            ->permissions(function (User $user) {
                return $user->hasRole('Admin');
            });

        return Item::create(__('Settings'))
            ->href('#settings-dropdown')
            ->icon('fas fa-cogs')
            ->permissions(['settings.general', 'settings.auth', 'settings.notifications'])
            ->addChildren([
                $document_types,
                $currencies,
                $payment_types,
                $organization_types,
                $expense_types,
                $general,
                $authAndRegistration,
                $notifications
            ]);
    }
}
