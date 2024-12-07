<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\FournisseurController;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Admin routes
    Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/fournisseurs', [FournisseurController::class, 'index'])->name('admin.fournisseurs');
        Route::post('/fournisseurs', [FournisseurController::class, 'store'])->name('admin.fournisseurs.store');
        Route::delete('/fournisseurs/{id}', [FournisseurController::class, 'destroy'])->name('admin.fournisseurs.destroy');
        Route::put('/fournisseurs/{id}', [FournisseurController::class, 'update'])->name('admin.fournisseurs.update');
    });

    // Manager routes
    Route::group(['prefix' => 'manager', 'middleware' => ['manager']], function () {
        Route::get('/', [ManagerController::class, 'index'])->name('manager.dashboard');
    });

    // Cashier routes
    Route::group(['prefix' => 'cashier', 'middleware' => ['cashier']], function () {
        Route::get('/', [CashierController::class, 'index'])->name('cashier.dashboard');
    });
});
