<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskTypeController;
use App\Http\Controllers\TaskController;
// // トップページ
// Route::get('/', function () {
//     return view('pages.index');
// })->name('home');

Route::get('/', function () {
    return redirect()->route('home'); // トップはログインページへリダイレクト
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])
        ->name('home');

    //カテゴリー表示
    Route::get('/task-types/{taskType}', [TaskTypeController::class, 'tasks'])
        ->name('tasks');
    //カテゴリー追加
    Route::post('/task-types', [TaskTypeController::class, 'store'])
        ->name('taskType.store');
    //カテゴリー編集
    Route::patch('/task-types/{taskType}', [TaskTypeController::class, 'update'])
        ->name('taskType.update');
    //カテゴリー削除
    Route::delete('/task-types/{taskType}', [TaskTypeController::class, 'destroy'])
        ->name('taskType.destroy');


    //タスク追加
    Route::post('/task-types/{taskType}/tasks', [TaskController::class, 'store'])
        ->name('task.store');
    //タスクステータス更新
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('task.status');
    //タスク編集
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])
        ->name('task.update');
    // タスク削除
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
        ->name('task.destroy');
});