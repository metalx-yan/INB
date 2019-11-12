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

Route::get('/json-products', 'ApiController@products');

Route::get('/json-branches', 'ApiController@branches');

Route::get('/json-groups', 'ApiController@groups');

Route::get('/json-prods', 'ApiController@prods');

Route::get('/json-regions', 'ApiController@regions');

Route::get('/json-months', 'ApiController@months');

Route::get('/json-days', 'ApiController@days');

Route::get('/json-month-balance', 'ApiController@monthBalance');

Route::get('/json-month-upload', 'ApiController@monthUpload');
