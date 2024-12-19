<?php

namespace App\Http\Controllers;

use App\Models\BonLivraison;
use App\Models\BonLivraisonDetail;
use App\Models\Client;
use App\Models\CommandeClient;
use App\Models\CommandeClientProduit;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class BonLivraisonController extends Controller
{
    public function index()
    {
        $bonsLivraison = BonLivraison::with('client')->latest()->paginate(10);
        return view('bons-livraison.index', compact('bonsLivraison'));
    }

    
    public function create()
    {
        $clients = Client::all();
        $produits = Produit::all();
        // Récupérer les commandes avec les produits associés
        $commandes = CommandeClient::where('statut', 'expediée')->with('commandeClientProduits.produit')->get();
        return view('bons-livraison.create', compact('clients', 'produits', 'commandes'));
    }


public function store(Request $request)
{
    // Pour examiner les données envoyées avant de valider
    dd($request->all());
    // Valider la requête entrante
    $request->validate([
        'commande_id' => 'required|exists:commande_clients,id',
        'date_livraison' => 'required|date',
        'produits' => 'required|array',  // Validation des produits envoyés
        'produits.*.produit_id' => 'required|exists:produits,id',  // Valider que chaque produit existe
        'produits.*.quantite' => 'required|integer|min:1',  // Validation de la quantité
        'produits.*.prix_unitaire_ht' => 'required|numeric|min:0',  // Validation du prix unitaire
        'produits.*.tva' => 'required|in:7,10,20',  // Validation de la TVA
        'produits.*.total_ligne_ht' => 'required|numeric|min:0',  // Validation du montant HT
        'produits.*.total_ligne_ttc' => 'required|numeric|min:0',  // Validation du montant TTC
    ]);

    // Récupérer la commande avec ses produits associés
    $commande = CommandeClient::with('commandeClientProduits.produit')->findOrFail($request->commande_id);

    // Générer un numéro de bon de livraison unique (Numéro BL)
    $numeroBl = Str::random(10);  // Ou une autre méthode pour générer un numéro unique

    // Créer le Bon de Livraison
    $bonLivraison = BonLivraison::create([
        'numero_bl' => $numeroBl,
        'client_id' => $commande->client_id,
        'commande_id' => $commande->id,
        'date_vente' => $commande->date_commande,
        'date_livraison' => $request->date_livraison,
        'total_ht' => 0, // Les totaux seront calculés après l'insertion des produits
        'total_ttc' => 0,
        'statut' => 'pending', // Ou en fonction de ta logique de statut
    ]);

    // Initialiser les totaux
    $totalHt = 0;
    $totalTtc = 0;

    // Insérer les détails du Bon de Livraison pour chaque produit dans le tableau 'produits' du formulaire
    foreach ($request->produits as $produit) {
        // Récupérer les informations du produit depuis le formulaire
        //$produitId = $produit->id;
        $quantite = $produit['quantite'];
        $prixUnitaireHt = $produit['prix_unitaire_ht'];
        $tva = $produit['tva'];
        $totalLigneHt = $produit['total_ligne_ht'];
        $totalLigneTtc = $produit['total_ligne_ttc'];

        // Insérer les détails du produit dans la table bon_livraison_details
        BonLivraisonDetail::create([
            'bon_livraison_id' => $bonLivraison->id,
            //'produit_id' => $produitId, // Passer le bon produit_id
            'quantite' => $quantite,
            'prix_unitaire_ht' => $prixUnitaireHt,
            'tva' => $tva,
            'total_ligne_ht' => $totalLigneHt,
            'total_ligne_ttc' => $totalLigneTtc,
        ]);

        // Accumuler les totaux HT et TTC
        $totalHt += $totalLigneHt;
        $totalTtc += $totalLigneTtc;
    }

    // Mettre à jour les totaux du Bon de Livraison
    $bonLivraison->update([
        'total_ht' => $totalHt,
        'total_ttc' => $totalTtc,
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('bons-livraison.index')->with('success', 'Bon de livraison créé avec succès');
}




    public function print(BonLivraison $bonLivraison)
    {
        $bonLivraison->load('details.produit');
        $pdf = Pdf::loadView('bons-livraison.pdf', compact('bonLivraison'));

        $filename = 'bon_livraison' . $bonLivraison->numero_bl . '.pdf';

        return $pdf->download($filename);
    }

    public function edit($id)
    {
        $bonLivraison = BonLivraison::findOrFail($id);
        $clients = Client::all();
        $produits = Produit::all();

        return view('bons-livraison.edit', compact('bonLivraison', 'clients', 'produits'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id', // Vérifier que le client existe
        'date_vente' => 'required|date', // La date de vente doit être une date valide
        'date_livraison' => 'required|date|after_or_equal:date_vente', // Livraison >= Vente
        'statut' => 'required|in:en_attente,livré,annulé',
        'references.*' => 'required|exists:produits,reference', // Chaque référence doit exister
        'quantites.*' => 'required|numeric|min:1', // Quantité minimale de 1
        'prix_unitaire_ht.*' => 'required|numeric|min:0', // Prix unitaire HT >= 0
        'tva.*' => 'required|in:7,10,20', // TVA >= 0
    ]);

    DB::transaction(function () use ($request, $id) {
        $bonLivraison = BonLivraison::findOrFail($id);

        // Mise à jour des champs principaux
        $bonLivraison->update([
            'client_id' => $request->client_id,
            'date_vente' => $request->date_vente,
            'date_livraison' => $request->date_livraison,
        ]);

        // Suppression des détails existants avant la mise à jour
        $bonLivraison->details()->delete();

        $totalHt = 0;
        $totalTtc = 0;

        // Réinsertion des détails
        foreach ($request->references as $index => $reference) {
            $ligneHt = $request->prix_unitaire_ht[$index] * $request->quantites[$index];
            $ligneTtc = $ligneHt * (1 + $request->tva[$index] / 100);

            BonLivraisonDetail::create([
                'bon_livraison_id' => $bonLivraison->id,
                'reference_produit' => $reference,
                'quantites' => $request->quantites[$index],
                'prix_unitaire_ht' => $request->prix_unitaire_ht[$index],
                'tva' => $request->tva[$index],
                'total_ligne_ht' => $ligneHt,
                'total_ligne_ttc' => $ligneTtc,
            ]);

            $totalHt += $ligneHt;
            $totalTtc += $ligneTtc;
        }


        // Mise à jour des totaux
        $bonLivraison->update([
            'total_ht' => $totalHt,
            'total_ttc' => $totalTtc,
        ]);
    });

    return redirect()->route('bons-livraison.index')
        ->with('success', 'Bon de livraison mis à jour avec succès.');
}

}
