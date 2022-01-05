<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\TodoInDayController;
use App\Http\Controllers\TodoInMonthController;
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

Route::get('sign_in', [LoginController::class, 'show']);
Route::post('sign_in', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout']);
Route::get('sign_up', [SignUpController::class, 'show']);
Route::post('sign_up', [SignUpController::class, 'signUp']);

Route::get('me/todo/day', [TodoInDayController::class, 'showDefault']);

Route::get('me/todo/month', [TodoInMonthController::class, 'showDefault']);


//常に一番下にする
Route::fallback([FallbackController::class, 'handl']);