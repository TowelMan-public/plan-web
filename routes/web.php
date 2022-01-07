<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrivateProjectController;
use App\Http\Controllers\ProjecController;
use App\Http\Controllers\PublicProjectController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\TodoInDayController;
use App\Http\Controllers\TodoInMonthController;
use App\Http\Controllers\UserConfigController;
use App\Http\Controllers\WithdrawalController;
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

Route::get('me/project/list', [ProjecController::class, 'showDefaultList']);
Route::get('me/project/month', [ProjecController::class, 'showDefaultListInMonth']);

Route::get('user/config', [UserConfigController::class, 'show']);
Route::post('user/config/core', [UserConfigController::class, 'updateUser']);
Route::post('user/config/notice', [UserConfigController::class, 'updateUserConfig']);

Route::get('withdrawal', [WithdrawalController::class, 'show']);
Route::post('withdrawal', [WithdrawalController::class, 'withdrawal']);

Route::get('/terminal', [TerminalController::class, 'showList']);
Route::post('/terminal/delete', [TerminalController::class, 'deleteTerminal']);

Route::get('/project/insert', [ProjecController::class, 'showInsertPage']);

Route::post('/project/public/insert', [PublicProjectController::class, 'insert']);
Route::post('/project/private/insert', [PrivateProjectController::class, 'insert']);

//常に一番下にする
Route::fallback([FallbackController::class, 'handl']);