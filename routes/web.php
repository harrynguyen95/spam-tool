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

Route::get('/', function () {
    return view('index');
});

Route::get('/share-location', function () {
    return view('share-location');
});

Route::get('/share-location-firebase', function () {
    return view('share-location-firebase');
});

Route::get('/share-location-firebase-hiennd', function () {
    return view('share-location-firebase-hiennd');
});
