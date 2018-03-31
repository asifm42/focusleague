<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/cycles/{cycle}/signups',   'Api\CycleSignupsController@store')
    ->name('api.cycle.signups.store')
    ->middleware('auth:api');
Route::put('/cyclesignups/{cyclesignup}',   'Api\CycleSignupsController@update')
    ->name('api.cyclesignups.put')
    ->middleware('auth:api');
Route::patch('/cyclesignups/{cyclesignup}',   'Api\CycleSignupsController@update')
    ->name('api.cyclesignups.patch')
    ->middleware('auth:api');
Route::delete('/cyclesignups/{cyclesignup}',   'Api\CycleSignupsController@destroy')
    ->name('api.cyclesignups.delete')
    ->middleware('auth:api');

Route::post('/cycles/{cycle}/subs',        'Api\CycleSubsController@store')
    ->name('api.cycle.subs.store')
    ->middleware('auth:api');
Route::put('/cycles/{cycle}/subs',        'Api\CycleSubsController@update')
    ->name('api.cycle.subs.put')
    ->middleware('auth:api');
Route::patch('/cycles/{cycle}/subs',        'Api\CycleSubsController@update')
    ->name('api.cycle.subs.patch')
    ->middleware('auth:api');
Route::delete('/cycles/{cycle}/subs',        'Api\CycleSubsController@destroy')
    ->name('api.cycle.subs.delete')
    ->middleware('auth:api');

Route::get('cycles/{cycle}',     'Api\CyclesController@show')
    ->name('api.cycles.get')
    ->middleware('auth:api');
    // Route::put(     'api/cyclesignups/{id}',         ['as' => 'api.cyclesignups.put', 'uses' => 'CycleSignupsController@apiUpdate']);
