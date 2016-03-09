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


Route::get('/welcomeemail', function () {
    $data = [
    'name' =>'asif',
    'email' => 'asif@test.com',
    'confirmation_code' => '11111',
    ];
    return view('emails.verification', $data);
});



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
 * User non-auth Routes
 */
Route::group(['middleware' => ['web']], function() {
    /*
     * Site Pages Route
     */
    Route::get(     '/',        ['as' => 'site.home',       'uses' => 'PagesController@welcome']);
    Route::get(     'faq',      ['as' => 'site.faq',        'uses' => 'PagesController@faq']);
    Route::get(     'pricing',  ['as' => 'site.pricing',    'uses' => 'PagesController@pricing']);
    Route::get(     'news',     ['as' => 'site.news',       'uses' => 'PostsController@index']);

    /*
     * Session Routes
     */
    Route::get(     'signin',               ['as' => 'sessions.create', 'uses' => 'SessionsController@create']);
    Route::post(    'signin',               ['as' => 'sessions.signin', 'uses' => 'SessionsController@signIn']);
    Route::get(     'signout',              ['as' => 'sessions.signout', 'uses' => 'SessionsController@signOut']);

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
    //
    Route::get('/token', function () {
        throw new TokenMismatchException();
        return view('site.welcome');
    });

});

Route::group(['middleware' => ['web','auth']], function() {

    /*
     * User Routes
     */
    Route::get(     'users/{id}',       ['as' => 'users.view', 'uses' => 'UsersController@show']);
    Route::get(     'dashboard',        ['as' => 'users.dashboard', 'uses' => 'UsersController@dashboard']);
    Route::get(     'users/{id}/edit',  ['as' => 'users.edit', 'uses' => 'UsersController@edit']);
    Route::patch(   'users/{id}',       ['as' => 'users.update', 'uses' => 'UsersController@update']);
    Route::put(     'users/{id}',       ['as' => 'users.put', 'uses' => 'UsersController@update']);
    Route::delete(  'users/{id}',       ['as' => 'users.destroy', 'uses' => 'UsersController@destroy']);

    /*
     * Cycle Routes
     */
    Route::get(     'cycles/{id}',          ['as' => 'cycles.view', 'uses' => 'CyclesController@show']);

    /*
     * Cycle Signup Routes
     */
    Route::get(     'cycles/{id}/signup',       ['as' => 'cycle.signup.create', 'uses' => 'CycleSignupsController@create']);
    Route::post(    'cycles/{id}/signup',       ['as' => 'cycle.signup.store', 'uses' => 'CycleSignupsController@store']);
    Route::get(     'cycles/{id}/signup/edit',  ['as' => 'cycle.signup.edit', 'uses' => 'CycleSignupsController@edit']);
    Route::patch(   'cycles/{id}/signup',       ['as' => 'cycle.signup.update', 'uses' => 'CycleSignupsController@update']);
    Route::put(     'cycles/{id}/signup',       ['as' => 'cycle.signup.put', 'uses' => 'CycleSignupsController@update']);
    Route::delete(  'cycles/{id}/signup',       ['as' => 'cycle.signup.destroy', 'uses' => 'CycleSignupsController@destroy']);

    /*
        Admin cycle signup routes
     */
    // How do we know which id, cycle or user?
    // Route::get(     'cyclesignups/{id}',         ['as' => 'cyclesignups.view', 'uses' => 'CycleSignupsController@show']);
    Route::get(     'cyclesignups/{id}/edit',    ['as' => 'cyclesignup.edit', 'uses' => 'CycleSignupsController@edit']);
    Route::patch(   'cyclesignups/{id}',         ['as' => 'cyclesignups.update', 'uses' => 'CycleSignupsController@update']);
    Route::put(     'cyclesignups/{id}',         ['as' => 'cyclesignups.put', 'uses' => 'CycleSignupsController@update']);
    // Route::delete(  'cyclesignups/{id}',         ['as' => 'cyclesignups.destroy', 'uses' => 'CycleSignupsController@destroy']);
});

Route::group(['middleware' => ['web','auth','admin']], function() {
    // Route::get(     'users',            ['as' => 'users.list', 'uses' => 'UsersController@index']);
});
