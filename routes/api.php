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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
    //     return $request->user();
    // });

Route::get('/json-year-balance', 'ApiController@getYear');

Route::get('/json-month-topbot', 'ApiController@getTopMonthDtd');

Route::get('/json-get-date', 'ApiController@getDate');

Route::get('/json-day-topbot', 'ApiController@getTopDayDtd');
    
Route::get('/json-group-matrix', 'ApiController@groupMatrix');

Route::get('/json-products', 'ApiController@products');
    
Route::get('/json-branches', 'ApiController@branches');

Route::get('/json-groups-avg', 'ApiController@groupsAvg');

Route::get('/json-groups', 'ApiController@groups');

Route::get('/json-prods', 'ApiController@prods');

Route::get('/json-prods-avg', 'ApiController@prodsAvg');

Route::get('/json-regions', 'ApiController@regions');

Route::get('/json-months', 'ApiController@months');

Route::get('/json-months-avg', 'ApiController@monthsAvg');

Route::get('/json-days-avg', 'ApiController@daysAvg');

Route::get('/json-days', 'ApiController@days');

Route::get('/json-month-balance', 'ApiController@monthBalance');

Route::get('/json-day-balance', 'ApiController@dayBalance');

Route::get('/json-month-upload', 'ApiController@monthUpload');

Route::get('/json-acc-matrix', 'ApiController@accMatrix');

Route::get('/json-date','ApiController@date');

