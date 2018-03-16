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

Route::post('/cycles/{cycle}/subs',        'Api\SubsController@store')
    ->name('api.sub.store')
    ->middleware('auth:api');

Route::get(     'cycles/{cycle}',     'Api\CyclesController@show')
    ->name('api.cycles.get')
    ->middleware('auth:api');
