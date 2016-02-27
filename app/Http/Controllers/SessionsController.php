<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{

    /**
     * Show the Sign In Form.
     *
     * @return View
     */
    public function create(Request $request)
    {
        return view('auth.signIn');
    }
}
