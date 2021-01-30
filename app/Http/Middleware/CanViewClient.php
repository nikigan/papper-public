<?php

namespace Vanguard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
    public function handle(Request $request, Closure $next)
    {

        $client = $request->route()->parameters['client'];

        if (!$client instanceof User) {
            $client = User::query()->findOrFail($client);
        }

        $user = $request->user();
        if ($client) {
            if ((!$user->is($client)) && (!$user->is($client->accountant)) && (!$user->is($client->auditor))) {
                abort(403);
            }
        }

        return $next($request);
    }
}
