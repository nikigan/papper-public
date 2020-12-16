<?php

/**
 * Authentication
 */

Route::group(['prefix' => 'client'], function () {
    Route::get('login', 'Auth\LoginController@show')->name('login');
    Route::post('login', 'Auth\LoginController@login')->name('login');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', 'Auth\LoginController@showAdmin')->name('login');
    Route::post('login', 'Auth\LoginController@loginAdmin')->name('login');
});

Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['middleware' => ['registration', 'guest']], function () {
    Route::get('register', 'Auth\RegisterController@show');
    Route::post('register', 'Auth\RegisterController@register');
});

Route::emailVerification();

Route::group(['middleware' => ['password-reset', 'guest']], function () {
    Route::resetPassword();
});

/**
 * Two-Factor Authentication
 */
Route::group(['middleware' => 'two-factor'], function () {
    Route::get('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@show')->name('auth.token');
    Route::post('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@update')->name('auth.token.validate');
});

/**
 * Social Login
 */
Route::get('auth/{provider}/login', 'Auth\SocialAuthController@redirectToProvider')->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

Route::group(['middleware' => ['auth', 'verified']], function () {

    /**
     * Impersonate Routes
     */
    Route::impersonate();

    /**
     * Dashboard
     */

    Route::get('/', 'DashboardController@index')->name('dashboard');

    /**
     * User Profile
     */

    Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {
        Route::get('/', 'ProfileController@show')->name('profile');
        Route::get('activity', 'ActivityController@show')->name('profile.activity');
        Route::put('details', 'DetailsController@update')->name('profile.update.details');

        Route::post('avatar', 'AvatarController@update')->name('profile.update.avatar');
        Route::post('avatar/external', 'AvatarController@updateExternal')
            ->name('profile.update.avatar-external');

        Route::put('login-details', 'LoginDetailsController@update')
            ->name('profile.update.login-details');

        Route::get('sessions', 'SessionsController@index')
            ->name('profile.sessions')
            ->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'SessionsController@destroy')
            ->name('profile.sessions.invalidate')
            ->middleware('session.database');
    });


    /**
     * User Management
     */
    Route::group(['prefix' => 'admin', 'middleware' => ['role:Admin']], function () {

        Route::resource('users', 'Users\UsersController')
            ->except('update')->middleware('permission:users.manage');

        Route::group(['prefix' => 'users/{user}', 'middleware' => 'permission:users.manage'], function () {
            Route::put('update/details', 'Users\DetailsController@update')->name('users.update.details');
            Route::put('update/login-details', 'Users\LoginDetailsController@update')
                ->name('users.update.login-details');

            Route::post('update/avatar', 'Users\AvatarController@update')->name('user.update.avatar');
            Route::post('update/avatar/external', 'Users\AvatarController@updateExternal')
                ->name('user.update.avatar.external');

            Route::get('sessions', 'Users\SessionsController@index')
                ->name('user.sessions')->middleware('session.database');

            Route::delete('sessions/{session}/invalidate', 'Users\SessionsController@destroy')
                ->name('user.sessions.invalidate')->middleware('session.database');

            Route::post('two-factor/enable', 'TwoFactorController@enable')->name('user.two-factor.enable');
            Route::post('two-factor/disable', 'TwoFactorController@disable')->name('user.two-factor.disable');
        });

       /* Route::group(['prefix' => 'document_types'], function () {
            Route::get('/', 'DocumentTypeController@index')->name('document_types.index');
            Route::post('/', 'DocumentTypeController@update')->name('document_types.update');
        });*/
        Route::resource('document_types', 'DocumentTypeController');

        Route::resource('currency', 'CurrencyController');

        Route::resource('payment_types', 'PaymentTypeController');

        Route::resource('organization_types', 'OrganizationTypeController');

        /**
         * Roles & Permissions
         */
        Route::group(['namespace' => 'Authorization'], function () {
            Route::resource('roles', 'RolesController')->except('show')->middleware('permission:roles.manage');

            Route::post('permissions/save', 'RolePermissionsController@update')
                ->name('permissions.save')
                ->middleware('permission:permissions.manage');

            Route::resource('permissions', 'PermissionsController')->middleware('permission:permissions.manage');
        });


        /**
         * Settings
         */

        Route::get('settings', 'SettingsController@general')->name('settings.general')
            ->middleware('permission:settings.general');

        Route::post('settings/general', 'SettingsController@update')->name('settings.general.update')
            ->middleware('permission:settings.general');

        Route::get('settings/auth', 'SettingsController@auth')->name('settings.auth')
            ->middleware('permission:settings.auth');

        Route::post('settings/auth', 'SettingsController@update')->name('settings.auth.update')
            ->middleware('permission:settings.auth');

        if (config('services.authy.key')) {
            Route::post('settings/auth/2fa/enable', 'SettingsController@enableTwoFactor')
                ->name('settings.auth.2fa.enable')
                ->middleware('permission:settings.auth');

            Route::post('settings/auth/2fa/disable', 'SettingsController@disableTwoFactor')
                ->name('settings.auth.2fa.disable')
                ->middleware('permission:settings.auth');
        }

        Route::post('settings/auth/registration/captcha/enable', 'SettingsController@enableCaptcha')
            ->name('settings.registration.captcha.enable')
            ->middleware('permission:settings.auth');

        Route::post('settings/auth/registration/captcha/disable', 'SettingsController@disableCaptcha')
            ->name('settings.registration.captcha.disable')
            ->middleware('permission:settings.auth');

        Route::get('settings/notifications', 'SettingsController@notifications')
            ->name('settings.notifications')
            ->middleware('permission:settings.notifications');

        Route::post('settings/notifications', 'SettingsController@update')
            ->name('settings.notifications.update')
            ->middleware('permission:settings.notifications');

        /**
         * Activity Log
         */

        Route::get('activity', 'ActivityController@index')->name('activity.index')
            ->middleware('permission:users.activity');

        Route::get('activity/user/{user}/log', 'Users\ActivityController@index')->name('activity.user')
            ->middleware('permission:users.activity');

        /**
         * Two-Factor Authentication Setup
         */

        Route::group(['middleware' => 'two-factor'], function () {
            Route::post('two-factor/enable', 'TwoFactorController@enable')->name('two-factor.enable');

            Route::get('two-factor/verification', 'TwoFactorController@verification')
                ->name('two-factor.verification')
                ->middleware('verify-2fa-phone');

            Route::post('two-factor/resend', 'TwoFactorController@resend')
                ->name('two-factor.resend')
                ->middleware('throttle:1,1', 'verify-2fa-phone');

            Route::post('two-factor/verify', 'TwoFactorController@verify')
                ->name('two-factor.verify')
                ->middleware('verify-2fa-phone');

            Route::post('two-factor/disable', 'TwoFactorController@disable')->name('two-factor.disable');
        });

    });


    /**
     * Document upload route
     */
    Route::group(['prefix' => 'documents'], function () {
        Route::get('/', 'DocumentController@index')->name('documents.index');
        Route::get('/upload', 'DocumentController@upload')->name('documents.upload')
            ->middleware('permission:document.upload');
        Route::get('/create', 'DocumentController@create')->name('document.create')->middleware('permission:document.upload');
        Route::post('/create', 'DocumentController@manualStore')->name('document.manualStore')->middleware('permission:document.upload');
        Route::post('/upload', 'DocumentController@store')->name('documents.store')
            ->middleware('permission:document.upload');
        Route::put('/{document}', 'DocumentController@update')->name('documents.update');
        Route::get('/{document}', 'DocumentController@show')->name('documents.show');
        Route::delete('/{document}', 'DocumentController@destroy')->name('documents.destroy')->middleware('permission:document.delete');
    });

    /**
     * Clients
     */

    Route::group(['prefix' => 'clients', 'middleware' => ['permission:clients.manage']], function () {
        Route::get('/', 'ClientController@index')->name('clients.index');
        Route::get('/create', 'ClientController@create')->name('clients.create');
        Route::post('/create', 'ClientController@store')->name('clients.store');
        Route::group(['middleware' => 'view.client'], function () {
            Route::get('/{client}', 'ClientController@show')->name('clients.show');
            Route::put('/{client}/accountant/{accountant}', 'ClientController@editAccountant')->name('clients.edit.accountant');
            Route::get('/{client}/documents', 'ClientController@documents')->name('clients.documents');
        });
    });

    /**
     * Accountants
     */

    Route::group(['prefix' => 'accountants', 'middleware' => 'permission:client.assign'], function () {
        Route::get('/', 'AccountantController@index')->name('accountants.index');
        Route::get('/create', 'AccountantController@create')->name('accountants.create');
        Route::post('/create', 'AccountantController@store')->name('accountants.store');
        Route::get('/{client}', 'AccountantController@show')->name('accountants.show');
    });


    /**
     * Invoices
     */
    Route::resource('invoice', "InvoiceController")->except('edit', 'update');
    Route::resource('customers', 'CustomerController');
    Route::get('invoice/{invoice}/download', 'InvoiceController@download')->name('invoice.download');
});


/**
 * Installation
 */

Route::group(['prefix' => 'install'], function () {
    Route::get('/', 'InstallController@index')->name('install.start');
    Route::get('requirements', 'InstallController@requirements')->name('install.requirements');
    Route::get('permissions', 'InstallController@permissions')->name('install.permissions');
    Route::get('database', 'InstallController@databaseInfo')->name('install.database');
    Route::get('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('install-app', 'InstallController@install')->name('install.install');
    Route::get('complete', 'InstallController@complete')->name('install.complete');
    Route::get('error', 'InstallController@error')->name('install.error');
});
