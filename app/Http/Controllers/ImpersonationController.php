<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('god')->except('stopImpersonating');
    }

    /**
     * Impersonate the given user.
     *
     * @param  Request  $request
     * @param  string  $userId
     * @return Response
     */
    public function impersonate(Request $request, $userId)
    {
        $request->session()->flush();

        // We will store the original user's ID in the session so we can remember who we
        // actually are when we need to stop impersonating the other user, which will
        // allow us to pull the original user back out of the database when needed.
        $request->session()->put(
            'impersonator', $request->user()->id
        );

        Auth::login(User::findOrFail($userId));

        return redirect('/dashboard');
    }

    /**
     * Stop impersonating and switch back to primary account.
     *
     * @param  Request  $request
     * @return Response
     */
    public function stopImpersonating(Request $request)
    {
        $currentId = Auth::id();

        // We will make sure we have an impersonator's user ID in the session and if the
        // value doesn't exist in the session we will log this user out of the system
        // since they aren't really impersonating anyone and manually hit this URL.
        if (! $request->session()->has('impersonator')) {
            Auth::logout();

            return redirect('/');
        }

        $userId = $request->session()->pull(
            'impersonator'
        );

        // After removing the impersonator user's ID from the session so we can retrieve
        // the original user. Then, we will flush the entire session to clear out any
        // stale data from while we were doing the impersonation of the other user.
        $request->session()->flush();

        Auth::login(User::findOrFail($userId));

        return redirect(route('users.show', $currentId));
    }
}
