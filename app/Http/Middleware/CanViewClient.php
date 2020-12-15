<?php

namespace Vanguard\Http\Middleware;

use Closure;
use Vanguard\User;

class CanViewClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $client = User::query()->find($request->route()->parameters['client']);
        $user = $request->user();
        if ($client) {
            if ((isset($client->accountant) && $client->accountant->id != $user->id) && (isset($client->auditor) && $client->auditor->id != $user->id)) {
                abort(403);
            }
        }
        return $next($request);
    }
}
