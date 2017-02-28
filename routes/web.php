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

/*
 * Non-Auth Routes
 * TO-DO UNTESTED
 *
 */
Route::get(     '/',        'PagesController@welcome')->name('site.home');
Route::get(     'faq',      'PagesController@faq')->name('site.faq');
Route::get(     'pricing',  'PagesController@pricing')->name('site.pricing');
Route::get(     'news',     'PostsController@index')->name('site.news');

/*
 * Contact us routes
 * TO-DO UNTESTED
 */
// Route::get(     'contact',      ['as' => 'contact.create', 'uses' => 'ContactsController@create']);
// Route::post(    'contact',      ['as' => 'contact.send', 'uses' => 'ContactsController@send']);

/*
 * Auth Routes
 * Middleware applied on the controller
 *
 */
Route::get(     'signin',   'Auth\LoginController@showLoginForm')->name('sessions.create');
Route::post(    'signin',   'Auth\LoginController@login')->name('sessions.signin');
Route::get(     'signout',  'Auth\LoginController@logout')->name('sessions.signout');

/*
 * Password Reset Routes
 * Middleware applied on the controller
 *
 */
Route::get(     'password/reset',           'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post(    'password/email',           'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get(     'password/reset/{token}',   'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post(    'password/reset',           'Auth\ResetPasswordController@reset');

/*
 * Registration Routes
 * Middleware applied on the controller
 *
 */
Route::get(     'signup',   'Auth\RegisterController@showRegistrationForm')->name('users.create');
Route::post(    'signup',  'Auth\RegisterController@register')->name('users.store');

/*
 * User Email verification routes
 * Middleware applied on the controller
 *
 */
Route::get(     'users/verify/{confirmationCode}',  'Auth\EmailVerificationController@verifyEmail')->name('users.verify');
Route::get(     'users/verification',       'Auth\EmailVerificationController@resetVerificationCodeForm')->name('users.resetVerificationCodeForm');
Route::post(    'users/verification',        'Auth\EmailVerificationController@resetVerificationCode')->name('users.resetVerificationCode');

/*
 * User Impersonation
 * middleware on controller
 */
Route::get('users/impersonate/{id}', 'ImpersonationController@impersonate')->name('users.impersonate');
Route::get('users/stop-impersonating', 'ImpersonationController@stopImpersonating')->name('users.impersonate.stop');


Route::group(['middleware' => ['auth','historyprovided']], function() {

    /*
     * User Routes
     */
    // following route is also in admin group. remove from there once page is updated with permissions
    // Route::get(     'users/{id}',       ['as' => 'users.show', 'uses' => 'UsersController@show']);
    Route::get(     'dashboard',        ['as' => 'users.dashboard', 'uses' => 'UsersController@dashboard']);

    /*
     * Cycle Routes
     */
    Route::get(     'cycles',               ['as' => 'cycles.index', 'uses' => 'CyclesController@index']);
    Route::get(     'cycles/{cycle}',          ['as' => 'cycles.view', 'uses' => 'CyclesController@show']);
    Route::get(     'cycles/current',       ['as' => 'cycles.current', 'uses' => 'CyclesController@show']);








    /*
     * Cycle Signup Routes
     * TO-DO UNTESTED
     */
    // Route::get(     'cycles/{id}/signup',       ['as' => 'cycle.signup.create', 'uses' => 'CycleSignupsController@create']);
    // Route::post(    'cycles/{id}/signup',       ['as' => 'cycle.signup.store', 'uses' => 'CycleSignupsController@store']);
    // Route::get(     'cycles/{id}/signup/edit',  ['as' => 'cycle.signup.edit', 'uses' => 'CycleSignupsController@edit']);
    // Route::patch(   'cycles/{id}/signup',       ['as' => 'cycle.signup.update', 'uses' => 'CycleSignupsController@update']);
    // Route::put(     'cycles/{id}/signup',       ['as' => 'cycle.signup.put', 'uses' => 'CycleSignupsController@update']);
    // Route::delete(  'cycles/{id}/signup',       ['as' => 'cycle.signup.destroy', 'uses' => 'CycleSignupsController@destroy']);






    /*
     * Sub Signup Routes
     * TO-DO UNTESTED
     */
    // Route::get(     'cycles/{id}/subs/signup',      ['as' => 'sub.create', 'uses' => 'SubsController@create']);
    // Route::post(    'cycles/{id}/subs',             ['as' => 'sub.store', 'uses' => 'SubsController@store']);
    // Route::get(     'subs/{id}/edit',               ['as' => 'sub.edit', 'uses' => 'SubsController@edit']);
    // Route::patch(   'subs/{id}',                    ['as' => 'sub.update', 'uses' => 'SubsController@update']);
    // Route::put(     'subs/{id}',                    ['as' => 'sub.put', 'uses' => 'SubsController@update']);
    // Route::delete(  'subs/{id}',                    ['as' => 'sub.destroy', 'uses' => 'SubsController@destroy']);


    /*
     * Transaction routes
     * TO-DO UNTESTED
     *
     */
    // Route::get(     'balance',      ['as' => 'balance.details', 'uses' => 'TransactionsController@index']);




});

// Ultimate history outside of historyprovided middleware or you'll be stuck in a loop
Route::group(['middleware' => ['auth']], function() {
    /*
     * Ultimate History Routes
     */
    // Route::get(     'ultimatehistory',                      ['as' => 'ultimate_history.create', 'uses' => 'UltimateHistoryController@create']);
    // Route::get(     'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.show', 'uses' => 'UltimateHistoryController@show']);
    // Route::post(    'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.store', 'uses' => 'UltimateHistoryController@store']);
    // Route::get(     'users/{id}/ultimatehistory/edit',      ['as' => 'users.ultimate_history.edit', 'uses' => 'UltimateHistoryController@edit']);
    // Route::patch(   'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.update', 'uses' => 'UltimateHistoryController@update']);
    // Route::put(     'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.put', 'uses' => 'UltimateHistoryController@update']);
    // Route::delete(  'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.destroy', 'uses' => 'UltimateHistoryController@destroy']);
});


Route::group(['middleware' => ['auth','admin']], function() {

    /*
        Log routes
     */
    Route::get('logs',              ['as' => 'admin.logs', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
});