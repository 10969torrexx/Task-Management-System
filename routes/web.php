<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSigninController;
use App\Http\Controllers\TasksController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/index', function() {
    return view('template.index');
});

# handle google
Route::post('auth/google', [GoogleSigninController::class, 'store'])->name('googleSignIn');

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', function() {
        return 'tasks';
    });
});