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
     * Contact us routes
     */
    Route::get(     'contact',      ['as' => 'contact.create', 'uses' => 'ContactsController@create']);
    Route::post(    'contact',      ['as' => 'contact.send', 'uses' => 'ContactsController@send']);

    /*
     * Session Routes
     */
    Route::get(     'signout',              ['as' => 'sessions.signout', 'uses' => 'SessionsController@signOut']);

    // Password reset link request routes...
    Route::get(     'password/email',       ['as' => 'password.emailForm', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post(    'password/email',       ['as' => 'password.email', 'uses' => 'Auth\PasswordController@postEmail']);

    // Password reset routes...
    Route::get(     'password/reset/{token}',           ['as' => 'password.resetForm', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post(    'password/reset',                   ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@postReset']);

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

/*
 * User non-auth Routes that can only be seen by guests.
 */
Route::group(['middleware' => ['web', 'guest']], function() {
    /*
     * Session Routes
     */
    Route::get(     'signin',               ['as' => 'sessions.create', 'uses' => 'SessionsController@create']);
    Route::post(    'signin',               ['as' => 'sessions.signin', 'uses' => 'SessionsController@signIn']);

    // User registration routes
    Route::get(     'signup',                           ['as' => 'users.create', 'uses' => 'UsersController@create']);
    Route::post(    'signup',                           ['as' => 'users.store', 'uses' => 'UsersController@store']);
});

// Ultimate history outside of historyprovided middleware or you'll be stuck in a loop
Route::group(['middleware' => ['web','auth']], function() {
    /*
     * Ultimate History Routes
     */
    Route::get(     'ultimatehistory',                      ['as' => 'ultimate_history.create', 'uses' => 'UltimateHistoryController@create']);
    Route::get(     'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.show', 'uses' => 'UltimateHistoryController@show']);
    Route::post(    'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.store', 'uses' => 'UltimateHistoryController@store']);
    Route::get(     'users/{id}/ultimatehistory/edit',      ['as' => 'users.ultimate_history.edit', 'uses' => 'UltimateHistoryController@edit']);
    Route::patch(   'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.update', 'uses' => 'UltimateHistoryController@update']);
    Route::put(     'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.put', 'uses' => 'UltimateHistoryController@update']);
    Route::delete(  'users/{id}/ultimatehistory',           ['as' => 'users.ultimate_history.destroy', 'uses' => 'UltimateHistoryController@destroy']);
});

Route::group(['middleware' => ['web','auth','historyprovided']], function() {

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
     * Sub Signup Routes
     */
    Route::get(     'cycles/{id}/subs/signup',      ['as' => 'sub.create', 'uses' => 'SubsController@create']);
    Route::post(    'cycles/{id}/subs',             ['as' => 'sub.store', 'uses' => 'SubsController@store']);
    Route::get(     'subs/{id}/edit',               ['as' => 'sub.edit', 'uses' => 'SubsController@edit']);
    Route::patch(   'subs/{id}',                    ['as' => 'sub.update', 'uses' => 'SubsController@update']);
    Route::put(     'subs/{id}',                    ['as' => 'sub.put', 'uses' => 'SubsController@update']);
    Route::delete(  'subs/{id}',                    ['as' => 'sub.destroy', 'uses' => 'SubsController@destroy']);

    /*
     * Sub Signup Routes
     */
    // Route::get(     'weeks/{id}/subs/signup',       ['as' => 'sub.create', 'uses' => 'SubsController@create']);
    // Route::post(    'weeks/{id}/subs/signup',       ['as' => 'sub.store', 'uses' => 'SubsController@store']);
    // Route::get(     'weeks/{id}/subs/signup/edit',  ['as' => 'sub.edit', 'uses' => 'SubsController@edit']);
    // Route::patch(   'weeks/{id}/subs/signup',       ['as' => 'sub.update', 'uses' => 'SubsController@update']);
    // Route::put(     'weeks/{id}/subs/signup',       ['as' => 'sub.put', 'uses' => 'SubsController@update']);
    // Route::delete(  'weeks/{id}/subs/signup',       ['as' => 'sub.destroy', 'uses' => 'SubsController@destroy']);




});

Route::group(['middleware' => ['web','auth','admin']], function() {
    // Route::get(     'users',            ['as' => 'users.list', 'uses' => 'UsersController@index']);



    Route::get(     'admin/dashboard',               ['as' => 'admin.dashboard', 'uses' => 'AdminsController@dashboard']);

    /*
     * Admin Ultimate History Routes
     */
    // Route::get(     'ultimatehistory',               ['as' => 'ultimate_history.create', 'uses' => 'UltimateHistoryController@create']);
    // Route::post(    'ultimatehistory',               ['as' => 'ultimate_history.store', 'uses' => 'UltimateHistoryController@store']);
    // Route::get(     'ultimatehistory/{id}',          ['as' => 'ultimate_history.view', 'uses' => 'UltimateHistoryController@show']);
    // Route::get(     'ultimatehistory/{id}/edit',     ['as' => 'ultimate_history.edit', 'uses' => 'UltimateHistoryController@edit']);
    // Route::patch(   'ultimatehistory/{id}',          ['as' => 'ultimate_history.patch', 'uses' => 'UltimateHistoryController@update']);
    // Route::put(     'ultimatehistory/{id}',          ['as' => 'ultimate_history.put', 'uses' => 'UltimateHistoryController@update']);
    // Route::delete(  'ultimatehistory/{id}',          ['as' => 'ultimate_history.destroy', 'uses' => 'UltimateHistoryController@destroy']);

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
