<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        return view('site.welcome');
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
