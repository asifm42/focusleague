<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get(     '/',        ['as' => 'site.home',       'uses' => 'PagesController@welcome']);

/*
 * Auth Routes
 * Middleware applied on the controller
 *
 */
Route::get(     'signin',   'Auth\LoginController@showLoginForm')->name('sessions.create');
Route::post(    'signin',   'Auth\LoginController@login')->name('sessions.signin');
Route::get(     'signout',  'Auth\LoginController@logout')->name('sessions.signout');

// Password Reset Routes...
Route::get(     'password/reset',           'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post(    'password/email',           'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get(     'password/reset/{token}',   'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post(    'password/reset',           'Auth\ResetPasswordController@reset');


Route::group(['middleware' => ['auth','historyprovided']], function() {

    /*
     * User Routes
     */
    // following route is also in admin group. remove from there once page is updated with permissions
    // Route::get(     'users/{id}',       ['as' => 'users.show', 'uses' => 'UsersController@show']);
    Route::get(     'dashboard',        ['as' => 'users.dashboard', 'uses' => 'UsersController@dashboard']);

});