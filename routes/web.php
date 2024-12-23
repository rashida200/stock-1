<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\BonAvoirController;
use App\Http\Controllers\BonCommandeController;
use App\Http\Controllers\BonDeCommandeController;
use App\Http\Controllers\BonLivraisonController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeClientController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\FactureAvoirController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\IdentifiantController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Models\Produit;
use App\Models\BonLivraison;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Admin routes

    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/fournisseurs', [FournisseurController::class, 'index'])->name('admin.fournisseurs');
    Route::post('/fournisseurs', [FournisseurController::class, 'store'])->name('admin.fournisseurs.store');
    Route::get('/fournisseurs/{fournisseur}/history', [FournisseurController::class, 'history'])->name('fournisseurs.history');
    Route::delete('/fournisseurs/{id}', [FournisseurController::class, 'destroy'])->name('admin.fournisseurs.destroy');
    Route::put('/fournisseurs/{id}', [FournisseurController::class, 'update'])->name('admin.fournisseurs.update');


    Route::resource('utilisateurs', UserController::class);


    Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
    Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
    Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');

    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::get('/clients/{client}/historique', [ClientController::class, 'historique'])->name('clients.historique');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

    Route::resource('bons-commande', BonCommandeController::class);
    Route::get('/bons-commande/{bonCommande}/print', [BonCommandeController::class, 'print'])->name('bons-commande.print');

    Route::resource('devis', DevisController::class);
    Route::get('/devis/{id}/print', [DevisController::class, 'print'])->name('devis.print');

    Route::resource('/bons-livraison', BonLivraisonController::class);
    Route::get('/bons-livraison/{bonLivraison}/print', [BonLivraisonController::class, 'print'])->name('bons-livraison.print');

    Route::resource('commandes', CommandeClientController::class);

    Route::resource('stock', StockController::class);


    Route::resource('factures', FactureController::class);
    Route::get('/factures/{facture}/print', [FactureController::class, 'print'])->name('factures.print');


    Route::resource('banques', BanqueController::class);

    Route::get('/identifiants', [IdentifiantController::class, 'show'])->name('identifiants.show');
    Route::post('/identifiants', [IdentifiantController::class, 'save'])->name('identifiants.save');

    Route::resource('bons-avoir', BonAvoirController::class);
    Route::get('bons-avoir/{bonAvoir}/print', [BonAvoirController::class, 'print'])
        ->name('bons-avoir.print');

    // Factures d'Avoir Routes
    Route::get('/factures-avoir', [FactureAvoirController::class, 'index'])
        ->name('factures-avoir.index');

    Route::get('/factures-avoir/create', [FactureAvoirController::class, 'create'])
        ->name('factures-avoir.create');

    Route::post('/factures-avoir', [FactureAvoirController::class, 'store'])
        ->name('factures-avoir.store');

    Route::get('/factures-avoir/{id}', [FactureAvoirController::class, 'show'])
        ->name('factures-avoir.show');

    Route::get('/factures-avoir/{factureAvoir}/print', [FactureAvoirController::class, 'print'])
        ->name('factures-avoir.print');
});
