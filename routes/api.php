<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function () {
    //  user

    Route::get('user', 'API\UserController@fetch');
    Route::post('logout', 'API\UserController@logout');
    Route::resource('permohonan', 'API\PermohonanController');
    Route::get('absen-radius', 'API\AbsenRadiusController@index');
    Route::resource('absen', 'API\AbsenControlle');
});


Route::post('login', 'API\UserController@login');
