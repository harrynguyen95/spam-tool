<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/location', function () {
    return response()->json([
        'data' => [
            'name' => 'hiennd',
            'avatar' => 'images/avt.png',
            'position' => [
                'lat' => 51.5,
                'lng' => -0.09,
                'time' => 'xxx'
            ],
            'expired_at' => '1697829693'
        ],
        'code' => 200
    ], 200);
});

Route::post('/get_source_file_content', 'App\Http\Controllers\DeviceController@getSourceFilecontent')->name('get_source_file_content');

