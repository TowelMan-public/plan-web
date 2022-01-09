<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrivateProjectController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicProjectController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\SubscriberController;
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

Route::get('me/project/list', [ProjectController::class, 'showDefaultList']);
Route::get('me/project/list/invitation', [ProjectController::class, 'showInvitationList']);
Route::get('me/project/month', [ProjectController::class, 'showDefaultListInMonth']);
Route::get('me/project/month/{year}/{month}', [ProjectController::class, 'showListInMonth'])
    ->name("ProjectController@showListInMonth");
Route::get('me/project/month/{year}/{month}/next', [ProjectController::class, 'nextMonthForListInMonth']);
Route::get('me/project/month/{year}/{month}/back', [ProjectController::class, 'backMonthForListInMonth']);

Route::get('user/config', [UserConfigController::class, 'show']);
Route::post('user/config/core', [UserConfigController::class, 'updateUser']);
Route::post('user/config/notice', [UserConfigController::class, 'updateUserConfig']);

Route::get('withdrawal', [WithdrawalController::class, 'show']);
Route::post('withdrawal', [WithdrawalController::class, 'withdrawal']);

Route::get('/terminal', [TerminalController::class, 'showList']);
Route::post('/terminal/delete', [TerminalController::class, 'deleteTerminal']);

Route::get('/project/insert', [ProjectController::class, 'showInsertPage']);

Route::post('/project/public/insert', [PublicProjectController::class, 'insert']);
Route::get('/project/public/{projectId}', [PublicProjectController::class, 'show'])
    ->name('PublicProjectController@show');
Route::post('/project/public/{projectId}/update', [PublicProjectController::class, 'update']);
Route::post('/project/public/{projectId}/delete', [PublicProjectController::class, 'delete']);
Route::post('/project/public/{projectId}/isCompleted', [PublicProjectController::class, 'setIsCompleted']);
Route::post('/project/public/{projectId}/accept', [PublicProjectController::class, 'accept']);
Route::post('/project/public/{projectId}/block', [PublicProjectController::class, 'block']);

Route::post('/project/private/insert', [PrivateProjectController::class, 'insert']);
Route::get('/project/private/{projectId}', [PrivateProjectController::class, 'show'])
    ->name('PrivateProjectController@show');
Route::post('/project/private/{projectId}/update', [PrivateProjectController::class, 'update']);
Route::post('/project/private/{projectId}/delete', [PrivateProjectController::class, 'delete']);

Route::get('/project/public/{projectId}/subscriber', [SubscriberController::class, 'show'])
    ->name('SubscriberController@show');
Route::post('/project/public/{projectId}/subscriber/invitation', [SubscriberController::class, 'invitation']);
Route::post('/project/public/{projectId}/subscriber/update', [SubscriberController::class, 'update']);
Route::post('/project/public/{projectId}/subscriber/delete', [SubscriberController::class, 'delete']);
Route::post('/project/public/{projectId}/exit', [SubscriberController::class, 'exit']);

//常に一番下にする
Route::fallback([FallbackController::class, 'handl']);