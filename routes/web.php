<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSigninController;
use App\Http\Controllers\TasksController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('/templates', function() {
    return view('template.forms-basic-inputs');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
# handle google
Route::post('auth/google', [GoogleSigninController::class, 'store'])->name('googleSignIn');

Route::middleware(['auth'])->group(function () {
    # tasks management
        Route::get('tasks/index', [TasksController::class, 'index'])->name('tasksIndex');
        Route::post('tasks/store', [TasksController::class, 'store'])->name('tasksStore');
});