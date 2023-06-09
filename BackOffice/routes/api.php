<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\TenantController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth::routes(['verify' => true]);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::group(
        [
            'prefix' => 'tenant',
            'middleware' => ['role:mahasiswa']
        ],
        function () {
            Route::get('index', [TenantController::class, 'index'])->name('tenant.index');
            Route::get('search/{value}', [TenantController::class, 'search'])->name('tenant.search');
        }
    );


    Route::group(
        [
            'prefix' => 'menu',
            'middleware' => ['role:mahasiswa']
        ],
        function () {
            Route::get('{tenant}', [MenuController::class, 'index'])->name('menu.index');
            // Route::get('menu/{tenant}/{value?}', [MenuController::class, 'filterOrsort'])->name('tenant.filterOrSort');
            // jek grung ganti method post
            Route::post('filter-or-sort', [MenuController::class, 'filterNSort'])->name('menu.sortNfilter');
            // Route::get('menu/{tenant}/{filter?}/{sort?}', [MenuController::class, 'filterNsort'])->name('tenant.sortNfilter');
            Route::get('{tenant}/product/{id}', [MenuController::class, 'viewProduct']);
            // Route::get('view-product/{tenant}/{id}', [MenuController::class, 'viewProduct']);
        }
    );

    Route::group([
        'prefix' => 'history',
        'middleware' => ['role:mahasiswa']
    ], function () {
        Route::get('index', [HistoryController::class, 'index'])->name('history');
        Route::get('history-detail/{id}', [HistoryController::class, 'history_detail'])->name('history.detail');
        // Route::get('{tenant}', [MenuController::class, 'index'])->name('menu.index');
    });

    Route::group(
        [
            'prefix' => 'cart',
            'middleware' => ['role:mahasiswa']
        ],
        function () {
            Route::get('index', [CartController::class, 'index']);
            Route::post('add-cart', [CartController::class, 'addCart'])->name('addCart');
            Route::post('add-note', [CartController::class, 'addNote']);
            Route::post('quantity', [CartController::class, 'quantity']);
            Route::post('checkout', [CartController::class, 'checkout']);
        }
    );

    Route::get('tes-auth', [UserController::class, 'tes']);
});
Route::get('trigger_whatsapp', [CartController::class, 'trigger_whatsapp']);

Route::post('login', [UserController::class, 'login']);

Route::post('register', [UserController::class, 'register']);

Route::get('tes', [UserController::class, 'tes']);
