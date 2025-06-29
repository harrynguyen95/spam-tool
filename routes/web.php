<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::get('/login', 'AuthController@showLoginForm')->name('login');
    Route::post('/login', 'AuthController@login')->name('login.submit');
    Route::get('/logout', 'AuthController@logout')->name('logout');

    // Route::group(['middleware' => ['auth']], function() {
        Route::get('/', 'DeviceController@index')->name('dashboard');

        Route::get('/devices', 'DeviceController@index')->name('device.index');
        Route::get('/devices/create', 'DeviceController@create')->name('device.create');
        Route::post('/devices', 'DeviceController@store')->name('device.store');
        Route::get('/devices/view/{id}', 'DeviceController@show')->name('device.show');
        Route::get('/devices/update/{id}', 'DeviceController@edit')->name('device.edit');
        Route::put('/devices/update/{id}', 'DeviceController@update')->name('device.update');

        Route::post('/devices/delete/{id}', 'DeviceController@destroy')->name('device.destroy');
        Route::post('/devices/setup/{id}', 'DeviceController@setup')->name('device.setup');
        Route::post('/devices/start/{id}', 'DeviceController@start')->name('device.start');
        Route::post('/devices/stop/{id}', 'DeviceController@stop')->name('device.stop');

        Route::post('/devices/bulk-action', 'DeviceController@bulkAction')->name('device.bulkAction');
        Route::post('/devices/startAll', 'DeviceController@startAll')->name('device.startAll');
        Route::post('/devices/stopAll', 'DeviceController@stopAll')->name('device.stopAll');
        
        Route::get('/autotouch', 'CommonController@listDevice')->name('autotouch.index');
        Route::post('/autotouch', 'CommonController@storeDevice')->name('autotouch.store');

        Route::post('/upload/folder', 'FolderController@upload')->name('upload');

        Route::get('/merge/file', 'MergeController@index')->name('merge.index');
        Route::post('/merge/file', 'MergeController@merge')->name('merge');

        Route::get('/compare/file', 'MergeController@getCompare')->name('compare.index');
        Route::post('/compare/file', 'MergeController@compare')->name('compare');

        Route::get('/split/text', 'SplitController@getSplit')->name('split.index');
        Route::post('/split/split', 'SplitController@split')->name('split');

        Route::get('/avatar/get', 'AvatarController@index')->name('avatar.index');
        Route::post('/avatar/get', 'AvatarController@store')->name('avatar.store');

        Route::get('/google/translate', 'CommonController@translateIndex')->name('translate.index');
        Route::post('/google/translate', 'CommonController@translateStore')->name('translate.store');

        Route::get('/google/location', 'CommonController@locationIndex')->name('location.index');
        Route::post('/google/location', 'CommonController@locationStore')->name('location.store');

        Route::get('/captions', 'CommonController@captionIndex')->name('caption.index');
        Route::post('/captions', 'CommonController@captionStore')->name('caption.store');

        Route::get('/shuffer', 'CommonController@shufferIndex')->name('shuffer.index');
        Route::post('/shuffer', 'CommonController@shufferStore')->name('shuffer.store');

        Route::get('/group-check', 'CommonController@groupCheckIndex')->name('group.check');

        Route::get('/folders/{id}/compare/nick', 'FolderController@compareNick')->name('folder.compare.nick');
        Route::get('/folders/{id}/compare/group', 'FolderController@compareGroup')->name('folder.compare.group');

        Route::get('/folders', 'FolderController@index')->name('folder.index');
        Route::get('/folders/create', 'FolderController@create')->name('folder.create');
        Route::post('/folders', 'FolderController@store')->name('folder.store');
        Route::get('/folders/view/{id}', 'FolderController@show')->name('folder.show');
        Route::get('/folders/update/{id}', 'FolderController@edit')->name('folder.edit');
        Route::put('/folders/update/{id}', 'FolderController@update')->name('folder.update');
        Route::delete('/folders/delete/{id}', 'FolderController@destroy')->name('folder.destroy');
        Route::delete('/folders/deleteAll', 'FolderController@deleteAll')->name('folder.deleteAll');


    // });
});
