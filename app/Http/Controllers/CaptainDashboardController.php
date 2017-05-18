<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptainDashboardController extends Controller
{
    /**
     * Display the page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('captains.dashboard');
    }
}
