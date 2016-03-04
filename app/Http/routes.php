<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });


/*
 * Site Pages Route
 */
Route::get(     '/',        ['as' => 'site.home',       'uses' => 'PagesController@welcome']);
// Route::get(     'news',     ['as' => 'site.news',       'uses' => 'PagesController@news']);
Route::get(     'faq',      ['as' => 'site.faq',        'uses' => 'PagesController@faq']);
Route::get(     'pricing',  ['as' => 'site.pricing',    'uses' => 'PagesController@pricing']);


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {


    // User registration routes
    Route::get(     'signup',       ['as' => 'users.create', 'uses' => 'UsersController@create']);
    Route::post(    'users',        ['as' => 'users.store', 'uses' => 'UsersController@store']);


    //
    Route::get('/token', function () {
        throw new TokenMismatchException;
        return view('welcome');
    });
});
