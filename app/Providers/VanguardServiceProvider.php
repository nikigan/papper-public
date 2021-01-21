<?php

namespace Vanguard\Providers;

use Vanguard\Announcements\Announcements;
use Vanguard\Plugins\VanguardServiceProvider as BaseVanguardServiceProvider;
use Vanguard\Support\Plugins\Accountants;
use Vanguard\Support\Plugins\Clients;
use Vanguard\Support\Plugins\Customers;
use Vanguard\Support\Plugins\Dashboard\Dashboard;
use Vanguard\Support\Plugins\Dashboard\Widgets\BannedUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\Expense;
use Vanguard\Support\Plugins\Dashboard\Widgets\Income;
use Vanguard\Support\Plugins\Dashboard\Widgets\LatestRegistrations;
use Vanguard\Support\Plugins\Dashboard\Widgets\NewUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\RegistrationHistory;
use Vanguard\Support\Plugins\Dashboard\Widgets\Taxes;
use Vanguard\Support\Plugins\Dashboard\Widgets\TotalClients;
use Vanguard\Support\Plugins\Dashboard\Widgets\TotalUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\UnconfirmedUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\UserActions;
use Vanguard\Support\Plugins\Dashboard\Widgets\WaitingDocuments;
use Vanguard\Support\Plugins\Invoices;
use Vanguard\Support\Plugins\RolesAndPermissions;
use Vanguard\Support\Plugins\Search;
use Vanguard\Support\Plugins\Reports;
use Vanguard\Support\Plugins\Settings;
use Vanguard\Support\Plugins\UnconfirmedDocuments;
use Vanguard\Support\Plugins\UploadDocument;
use Vanguard\Support\Plugins\Users;
use Vanguard\Support\Plugins\Vendors;
use Vanguard\UserActivity\UserActivity;
use \Vanguard\UserActivity\Widgets\ActivityWidget;

class VanguardServiceProvider extends BaseVanguardServiceProvider
{
    /**
     * List of registered plugins.
     *
     * @return array
     */
    protected function plugins()
    {
        return [
            Dashboard::class,
            Search::class,
            UploadDocument::class,
            UnconfirmedDocuments::class,
            Vendors::class,
            Invoices::class,
            Customers::class,
            Clients::class,
            Accountants::class,
            Users::class,
//            UserActivity::class,
            RolesAndPermissions::class,
            Reports::class,
            Settings::class,
            Announcements::class
        ];
    }

    /**
     * Dashboard widgets.
     *
     * @return array
     */
    protected function widgets()
    {
        return [
            Income::class,
            Expense::class,
            Taxes::class,
//            UserActions::class,
            TotalUsers::class,
            NewUsers::class,
            BannedUsers::class,
            UnconfirmedUsers::class,
            RegistrationHistory::class,
            LatestRegistrations::class,
            TotalClients::class,
            WaitingDocuments::class
//            ActivityWidget::class,
        ];
    }
}
