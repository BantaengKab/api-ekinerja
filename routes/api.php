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
    Route::post('update-profile', 'API\UserController@upload_profile');
    Route::post('logout', 'API\UserController@logout');
    Route::resource('permohonan', 'API\PermohonanController');
    Route::get('absen-radius', 'API\AbsenRadiusController@index');
    Route::resource('absen', 'API\AbsenController');
    Route::get('get-absen', 'API\AbsenController@index');


    Route::get('get-rencana-aksi', 'API\RencanaController@index');
});

Route::get('tes/{kode}', 'API\UserController@functionTest');

Route::resource('vaksin', 'API\VaksinController');
Route::post('login-vaksin', 'API\VaksinController@login');
Route::post('login', 'API\UserController@login');
