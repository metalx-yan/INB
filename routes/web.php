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
// Route::group(['prefix' => 'user', 'middleware' => ['auth']], function() {
// Route::group(['middleware' => ['auth']], function() {

    
    // });
    // Route::get('/app', function () {
        //     return view('button');
        // })->name('button');
        
Route::group(['middleware' => ['auth']], function() {

    Route::get('/user/viewdata/{id}', 'UserController@viewData')->name('viewdata');

    Route::put('/user/updatedata/{id}', 'UserController@updatePassword')->name('updatedata');

    Route::put('/user/resetdata/{id}', 'UserController@resetPassword')->name('resetdata');

    Route::put('profile/{id}', 'UserController@uploadPhoto')->name('uploadphoto');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'level:admin']], function() {

    Route::get('logActivity', 'UserController@logActivity')->name('log.admin');

    Route::get('add-to-log', 'UserController@myTestAddToLog');

    Route::get('/applications', 'ParentController@showApplication')->name('app');

    Route::resource('submenus', 'SubMenuController');

    Route::get('/', function () {
        return view('dashboard');
    })->name('home.admin');

    Route::resource('menus', 'PermissionController');

    Route::resource('application', 'ParentController');

    Route::resource('region', 'RegionController');

    Route::resource('managementunit', 'ManagementUnitController');

    Route::resource('level', 'LevelController');

    Route::resource('joblevel', 'JobLevelController');

    Route::resource('user', 'UserController');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'level:user']], function() {

    Route::get('query-balance' , 'QueryController@getBalance')->name('query-balance');

    Route::get('upload-file' , 'QueryController@getFile')->name('upload-file');

    Route::get('logActivity', 'UserController@logActivity')->name('log.user');

    Route::get('/', function () {
        \LogActivity::addToLog('Open Beranda');
        return view('dashboard');
    })->name('home.user');

});

Route::get('/', function () {
    return view('welcome');
})->name('root');

Auth::routes();

Route::get('test', function () {
    return view('test');
});


