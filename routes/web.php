<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return view('test');
});

Route::get('sign_in', 'LoginController@show');
Route::post('sign_in', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::get('sign_up', 'SignUpController@show');
Route::post('sign_in', 'LoginController@signUp');