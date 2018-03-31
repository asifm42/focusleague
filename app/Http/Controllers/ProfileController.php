<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = auth()->user();
        $user->load('ultimateHistory');
        $data['user'] = $user;

        return view('users.profile', $data );
    }
}