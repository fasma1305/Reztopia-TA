<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('clear', function () {

    Artisan::call('optimize:clear');
    return back();
    dd("Cache is cleared");
});
Route::redirect('/', 'dashboard');
Route::get('email', [EmailController::class, 'index']);

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

Route::group(
    [
        'middleware' => ['auth', 'role:admin']
    ],
    function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('tenant', [TenantController::class, 'index'])->name('tenant');
        Route::post('tenant', [TenantController::class, 'store'])->name('tenant.store');
        Route::post('tenant/{id}', [TenantController::class, 'update'])->name('tenant.update');
        Route::get('tenant/{id}', [TenantController::class, 'destroy'])->name('tenant.destroy');
        Route::get('tenant-control', [TenantController::class, 'tenantControl'])->name('tenant-control');
        Route::get('tenant-control/{id}', [TenantController::class, 'changeActiveTenant'])->name('changeActiveTenant');
    }
);

Route::group(
    [
        'middleware' => ['auth', 'role:admin,kantin']
    ],
    function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::get('laporan/{id}', [LaporanController::class, 'index_admin'])->name('laporan_admin');
        Route::post('laporan/date', [LaporanController::class, 'filter_date'])->name('filter_date');
        Route::get('print_laporan/{date}/{id}', [LaporanController::class, 'print'])->name('print');
        Route::get('pesanan', [LaporanController::class, 'pesanan'])->name('pesanan');
        Route::post('pesanan', [LaporanController::class, 'accept_order'])->name('accept_order');
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('profile/update_profile', [ProfileController::class, 'update_profile'])->name('update_profile');
        Route::post('profile/update_image_profile', [ProfileController::class, 'update_image_profile'])->name('update_image_profile');
        Route::post('profile/change_password', [ProfileController::class, 'change_password'])->name('change_password');
    }
);

Route::group(
    [
        'middleware' => ['auth', 'role:kantin']
    ],
    function () {
        Route::get('menu', [MenuController::class, 'index'])->name('menu');
        Route::post('menu/category', [MenuController::class, 'store'])->name('menu.store');
        Route::post('menu/product/delete', [MenuController::class, 'destroy_product'])->name('menu.destroy.product');
        Route::post('menu/product/store', [MenuController::class, 'store_product'])->name('menu.store.product');
        Route::post('menu/category/delete', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::post('menu/category/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::post('menu/product/{id}', [MenuController::class, 'update_product'])->name('menu.update.product');
    }
);

Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Route::get('/forgot-password', function () {
//     return view('tenant.auth.forgot-password');
// })->name('forgot-password');

// Route::get('/sent-forgot-password', function () {
//     return view('tenant.auth.sent-forgot-password');
// })->name('sent-forgot-password');

// Route::get('/success-reset', function () {
//     return view('tenant.auth.success-reset');
// })->name('success-reset');
