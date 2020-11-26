<?php

namespace Vanguard\Providers;

use Vanguard\Announcements\Announcements;
use Vanguard\Plugins\VanguardServiceProvider as BaseVanguardServiceProvider;
use Vanguard\Support\Plugins\Dashboard\Dashboard;
use Vanguard\Support\Plugins\Dashboard\Widgets\BannedUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\LatestRegistrations;
use Vanguard\Support\Plugins\Dashboard\Widgets\NewUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\RegistrationHistory;
use Vanguard\Support\Plugins\Dashboard\Widgets\TotalUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\UnconfirmedUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\UserActions;
use Vanguard\Support\Plugins\RolesAndPermissions;
use Vanguard\Support\Plugins\Settings;
use Vanguard\Support\Plugins\UploadDocument;
use Vanguard\Support\Plugins\Users;
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
            Users::class,
            UserActivity::class,
            RolesAndPermissions::class,
            Settings::class,
            Announcements::class,
            UploadDocument::class
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
            UserActions::class,
            TotalUsers::class,
            NewUsers::class,
            BannedUsers::class,
            UnconfirmedUsers::class,
            RegistrationHistory::class,
            LatestRegistrations::class,
            ActivityWidget::class,
        ];
    }
}
