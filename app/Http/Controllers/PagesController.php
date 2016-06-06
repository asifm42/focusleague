<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Cycle;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Displays the welcome page
     *
     * @link http://laravel.com/api/5.1/Illuminate/Http/Response.html
     *
     * @return \Illuminate\Http\Response.html
     */
    public function welcome()
    {
        $data['current_cycle'] = Cycle::current_cycle();
        $data['next_cycle'] = Cycle::next_cycle();

        return view('site.welcome', $data);
    }

    /**
     * Displays the news page
     *
     * @link http://laravel.com/api/5.1/Illuminate/Http/Response.html
     *
     * @return \Illuminate\Http\Response.html
     */
    public function news()
    {
        return view('site.news');
    }


    /**
     * Displays the faq page
     *
     * @link http://laravel.com/api/5.1/Illuminate/Http/Response.html
     *
     * @return \Illuminate\Http\Response.html
     */
    public function faq()
    {
        return view('site.faq');
    }

    /**
     * Displays the pricing page
     *
     * @link http://laravel.com/api/5.1/Illuminate/Http/Response.html
     *
     * @return \Illuminate\Http\Response.html
     */
    public function pricing()
    {
        return view('site.pricing');
    }
}
