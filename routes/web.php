<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjecListController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\TodoInDayController;
use App\Http\Controllers\TodoInMonthController;
use App\Http\Controllers\UserConfigController;
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

Route::get('me/project/list', [ProjecListController::class, 'showDefaultList']);
Route::get('me/project/month', [ProjecListController::class, 'showDefaultListInMonth']);

Route::get('user/config', [UserConfigController::class, 'show']);


//常に一番下にする
Route::fallback([FallbackController::class, 'handl']);