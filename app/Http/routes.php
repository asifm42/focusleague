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


Route::get('/welcome', function () {
    return view('welcome');
});


/*
 * Site Pages Route
 */
Route::get(     '/',        ['as' => 'site.home',       'uses' => 'PagesController@welcome']);
Route::get(     'news',     ['as' => 'site.news',       'uses' => 'PagesController@news']);
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


/*
 * Session Routes
 */
Route::get(     'signout',              ['as' => 'sessions.signout', 'uses' => 'SessionsController@signOut']);


/*
 * User non-auth Routes
 */
Route::group(['middleware' => ['web','guest']], function() {

    /*
     * Session Routes
     */
    Route::get(     'signin',               ['as' => 'sessions.create', 'uses' => 'SessionsController@create']);
    Route::post(    'signin',               ['as' => 'sessions.signin', 'uses' => 'SessionsController@signIn']);

    // Password reset link request routes...
    Route::get(     'password/email',       ['as' => 'password.emailForm', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post(    'password/email',       ['as' => 'password.email', 'uses' => 'Auth\PasswordController@postEmail']);

    // Password reset routes...
    Route::get(     'password/reset/{token}',           ['as' => 'password.resetForm', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post(    'password/reset',                   ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@postReset']);

    // User registration routes
    Route::get(     'signup',                           ['as' => 'users.create', 'uses' => 'UsersController@create']);
    Route::post(    'signup',                           ['as' => 'users.store', 'uses' => 'UsersController@store']);

    // User verification routes
    Route::get(     'users/verify',                     ['as' => 'users.verify', 'uses' => 'UsersController@verify']);
    Route::get(     'users/verification',               ['as' => 'users.resetVerificationCodeForm', 'uses' => 'UsersController@resetVerificationCodeForm']);
    Route::post(    'users/verification',               ['as' => 'users.resetVerificationCode', 'uses' => 'UsersController@resetVerificationCode']);
});



Route::group(['middleware' => ['web']], function () {
    //
    Route::get('/token', function () {
        throw new TokenMismatchException;
        return view('welcome');
    });
});
