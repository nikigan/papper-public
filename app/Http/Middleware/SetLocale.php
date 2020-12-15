<?php

namespace Vanguard\Http\Middleware;

use Closure;

class SetLocale
{
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

        app()->setLocale($locale);

        return $next($request);
    }
}
