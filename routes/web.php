<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\Task\CommentController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('tasks', TaskController::class)->only(['index']);
Route::resource('task_statuses', TaskStatusController::class)->only(['index']);
Route::resource('labels', LabelController::class)->only(['index']);

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class)->except(['index']);
    Route::resource('task_statuses', TaskStatusController::class)->except(['show', 'index']);
    Route::resource('labels', LabelController::class)->except(['show', 'index']);
    Route::resource('tasks.comments', CommentController::class)->shallow()->only([
        'store', 'destroy'
    ]);
});

Auth::routes();
