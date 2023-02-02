<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YandexDiskController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    Route::post('/view', 'YandexDiskController@View')->name('api.yadisk.view');
    Route::post('/delete', 'YandexDiskController@Delete')->name('api.yadisk.delete');
    Route::post('/upload', 'YandexDiskController@Upload')->name('api.yadisk.upload');
    Route::post('/save', 'YandexDiskController@Save')->name('api.yadisk.save');
});
