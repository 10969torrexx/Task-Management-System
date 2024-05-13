<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSigninController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/index', function() {
    return view('template.cards-basic');
});

# handle google
Route::post('auth/google', [GoogleSigninController::class, 'store'])->name('googleSignIn');
