<?php

use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => 'auth'
        // 'middleware' => 'auth', 'role:admin'
    ],
    function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('post_login', [AuthController::class, 'post_login'])->name('post_login');
        Route::get('forgot-password', [AuthController::class, 'forgot'])->name('forgot-password');
        // Route::get('register', [AuthController::class, 'register'])->name('register');
        // Route::post('register', [AuthController::class, 'post_register'])->name('post_register');
    }
);

