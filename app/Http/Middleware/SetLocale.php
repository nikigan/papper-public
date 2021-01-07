<?php

namespace Vanguard\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SetLocale
{

    protected $auth;
    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $locale
     * @return mixed
     */
    public function handle($request, Closure $next, $locale = 'en')
    {
        if (auth()->user() && auth()->user()->hasRole('Admin')) {
            app()->setLocale('en');
            Config::set('app.dir', 'ltr');
        }

        return $next($request);
    }
}
