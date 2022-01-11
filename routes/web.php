<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrivateProjectController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicProjectController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoInProjectController;
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

Route::get('me/todo/day', [TodoController::class, 'showDefaultInDay']);
Route::get('me/todo/day/{year}/{month}/{day}', [TodoController::class, 'showInDay'])
    ->name("TodoController@showInDay");
Route::get('me/todo/day/{year}/{month}/{day}/next', [TodoController::class, 'showNextInDay']);
Route::get('me/todo/day/{year}/{month}/{day}/back', [TodoController::class, 'showBackInDay']);

Route::get('me/todo/month', [TodoController::class, 'showDefaultInMonth']);
Route::get('me/todo/month/{year}/{month}', [TodoController::class, 'showInMonth'])
    ->name("TodoController@showInMonth");
Route::get('me/todo/month/{year}/{month}/next', [TodoController::class, 'showNextInMonth']);
Route::get('me/todo/month/{year}/{month}/back', [TodoController::class, 'showBackInMonth']);

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

Route::get('project/private/{projectId}/todo/onProject/day', [TodoInProjectController::class, 'showDefaultTodoInPrivateProjectInDay']);
Route::get('project/private/{projectId}/todo/onProject/day/{year}/{month}/{day}', [TodoInProjectController::class, 'showTodoInPrivateProjectInDay'])
    ->name("TodoInProjectController@showTodoInPrivateProjectInDay");
Route::get('project/private/{projectId}/todo/onProject/day/{year}/{month}/{day}/next', [TodoInProjectController::class, 'showTodoInPrivateProjectInDayNext']);
Route::get('project/private/{projectId}/todo/onProject/day/{year}/{month}/{day}/back', [TodoInProjectController::class, 'showTodoInPrivateProjectInDayBack']);

Route::get('project/private/{projectId}/todo/onProject/month', [TodoInProjectController::class, 'showDefaultTodoInPrivateProjectInMonth']);
Route::get('project/private/{projectId}/todo/onProject/month/{year}/{month}', [TodoInProjectController::class, 'showTodoInPrivateProjectInMonth'])
    ->name("TodoInProjectController@showTodoInPrivateProjectInMonth");
Route::get('project/private/{projectId}/todo/onProject/month/{year}/{month}/next', [TodoInProjectController::class, 'showTodoInPrivateProjectInMonthNext']);
Route::get('project/private/{projectId}/todo/onProject/month/{year}/{month}/back', [TodoInProjectController::class, 'showTodoInPrivateProjectInMonthBack']);

Route::get('project/public/{projectId}/todo/onProject/day', [TodoInProjectController::class, 'showDefaultTodoInPublicProjectInDay']);
Route::get('project/public/{projectId}/todo/onProject/day/{year}/{month}/{day}', [TodoInProjectController::class, 'showTodoInPublicProjectInDay'])
    ->name("TodoInProjectController@showTodoInPublicProjectInDay");
Route::get('project/public/{projectId}/todo/onProject/day/{year}/{month}/{day}/next', [TodoInProjectController::class, 'showTodoInPublicProjectInDayNext']);
Route::get('project/public/{projectId}/todo/onProject/day/{year}/{month}/{day}/back', [TodoInProjectController::class, 'showTodoInPublicProjectInDayBack']);

Route::get('project/public/{projectId}/todo/onProject/month', [TodoInProjectController::class, 'showDefaultTodoPublicProjectInMonth']);
Route::get('project/public/{projectId}/todo/onProject/month/{year}/{month}', [TodoInProjectController::class, 'showTodoInPublicProjectInMonth'])
    ->name("TodoInProjectController@showTodoInPublicProjectInMonth");
Route::get('project/public/{projectId}/todo/onProject/month/{year}/{month}/next', [TodoInProjectController::class, 'showTodoInPublicProjectInMonthNext']);
Route::get('project/public/{projectId}/todo/onProject/month/{year}/{month}/back', [TodoInProjectController::class, 'showTodoInPublicProjectInMonthBack']);

Route::get('project/public/{projectId}/todo/onResponsible/day', [TodoInProjectController::class, 'showDefaultResponsibleTodoInPublicProjectInDay']);
Route::get('project/public/{projectId}/todo/onResponsible/day/{year}/{month}/{day}', [TodoInProjectController::class, 'showResponsibleTodoInPublicProjectInDay'])
    ->name("TodoInProjectController@showResponsibleTodoInPublicProjectInDay");
Route::get('project/public/{projectId}/todo/onResponsible/day/{year}/{month}/{day}/next', [TodoInProjectController::class, 'showResponsibleTodoInPublicProjectInDayNext']);
Route::get('project/public/{projectId}/todo/onResponsible/day/{year}/{month}/{day}/back', [TodoInProjectController::class, 'showResponsibleTodoInPublicProjectInDayBack']);

Route::get('project/public/{projectId}/todo/onResponsible/month', [TodoInProjectController::class, 'showResponsibleTodaulPublicPrivateProjectInMonth']);
Route::get('project/public/{projectId}/todo/onResponsible/month/{year}/{month}', [TodoInProjectController::class, 'showResponsibleTodoInPublicProjectInMonth'])
    ->name("TodoInProjectController@showResponsibleTodoInPublicProjectInMonth");
Route::get('project/public/{projectId}/todo/onResponsible/month/{year}/{month}/next', [TodoInProjectController::class, 'showResponsibleTodoInPublicProjectInMonthNext']);
Route::get('project/public/{projectId}/todo/onResponsible/month/{year}/{month}/back', [TodoInProjectController::class, 'showResponsibleTodoInPublicProjectInMonthBack']);

Route::get('project/private/{projectId}/todo/insert', [TodoInProjectController::class, 'showInsertTodoToPrivateProject'])
    ->name("TodoInProjectController@showInsertTodoToPrivateProject");
Route::post('project/private/{projectId}/todo/insert', [TodoInProjectController::class, 'insertTodoToPrivateProject']);

Route::get('project/public/{projectId}/todo/insert', [TodoInProjectController::class, 'showInsertTodoToPublicProject'])
    ->name("TodoInProjectController@showInsertTodoToPublicProject");
Route::post('project/public/{projectId}/todo/insert', [TodoInProjectController::class, 'insertTodoToPublicProject']);

//常に一番下にする
Route::fallback([FallbackController::class, 'handl']);