<?php

namespace Vanguard\Providers;
use Vanguard\Announcements\Announcements;
use Vanguard\Plugins\VanguardServiceProvider as BaseVanguardServiceProvider;

use Illuminate\Support\ServiceProvider;
use Vanguard\Support\Plugins\Accountants;
use Vanguard\Support\Plugins\Clients;
use Vanguard\Support\Plugins\Customers;
use Vanguard\Support\Plugins\Invoices;
use Vanguard\Support\Plugins\RolesAndPermissions;
use Vanguard\Support\Plugins\Reports;
use Vanguard\Support\Plugins\LastDocuments;
use Vanguard\Support\Plugins\Users;
use Vanguard\UserActivity\UserActivity;

class AdminPluginsProvider extends BaseVanguardServiceProvider
{
    protected function widgets()
    {
        // TODO: Implement widgets() method.
    }

    protected function plugins()
    {
        return [
            Users::class,
//            UserActivity::class,
            RolesAndPermissions::class,
            Reports::class,
            Announcements::class
        ];
    }
}
