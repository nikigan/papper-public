<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Vanguard\Http\Controllers\Controller;
use Vanguard\OrganizationType;
use Vanguard\User;

class InviteController extends Controller
{
    public function inviteClient(Request $request, User $user)
    {
        $types = OrganizationType::all()->pluck('name', 'id');

        $token = $request->query('token');

        return view('auth.invite', [
            'client' => true,
            'organization_types' => $types,
            'token' => $token,
            'user' => $user,
            'accountant' => $user->hasRole('Accountant')
        ]);
    }

    public function updateClient(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8'
        ]);

        $token = Crypt::decrypt($request->token);

        if ($token == $user->id) {

            $user->update($request->all());

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', __('You have been registered successfully'));
        } else {
            abort(403);
        }
    }
}
