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

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/', 'MainController@dashboard')->name('dashboard');

        Route::post('/upload/folder', 'MainController@upload')->name('upload');

        Route::get('/folders', 'MainController@index')->name('folder.index');
        Route::get('/folders/create', 'MainController@create')->name('folder.create');
        Route::post('/folders', 'MainController@store')->name('folder.store');
        Route::get('/folders/view/{id}', 'MainController@show')->name('folder.show');
        Route::get('/folders/update/{id}', 'MainController@edit')->name('folder.edit');
        Route::put('/folders/update/{id}', 'MainController@update')->name('folder.update');
        Route::delete('/folders/delete/{id}', 'MainController@destroy')->name('folder.destroy');

    });
});
