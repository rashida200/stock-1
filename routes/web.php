<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BonCommandeController;
use App\Http\Controllers\BonDeCommandeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProduitController;

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
        Route::resource('utilisateurs', UserController::class)->except(['show']);
        Route::delete('/utilisateurs/{user}', [UserController::class, 'destroy'])->name('utilisateurs.destroy');



        Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
        Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
        Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
        Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');

        Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
        Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
        Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

        Route::resource('bons-commande', BonCommandeController::class);
        Route::get('/bons-commande/{bonCommande}/print', [BonCommandeController::class, 'print'])->name('bons-commande.print');

        Route::resource('devis', DevisController::class);
        Route::get('/devis/{id}/print', [DevisController::class, 'print'])->name('devis.print');


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
