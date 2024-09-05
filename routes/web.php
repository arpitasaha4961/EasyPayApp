<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Container\Attributes\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware'=> 'guest'],function(){
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register_view'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::group(['middleware'=> 'auth'],function(){
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('dashboard', [AuthController::class, 'deshboard'])->name('dashboard');
});

