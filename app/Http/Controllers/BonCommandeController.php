<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\BonCommandeDetail;
use App\Models\Fournisseur;
use App\Models\Produit;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class BonCommandeController extends Controller
{
    public function index()
    {
        $bonsCommande = BonCommande::with('fournisseur')->latest()->paginate(10);
        return view('bons-commande.index', compact('bonsCommande'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $produits = Produit::select('reference', 'designation')->get();
        return view('bons-commande.create', compact('fournisseurs', 'produits'));
    }

    public function store(Request $request)
{
    $request->validate([
        'fournisseur_id' => 'required|exists:fournisseurs,id',
        'date_commande' => 'required|date',
        'references.*' => 'required|exists:produits,reference',
        'statut' => 'required|in:en_attente,valide,annule',
        'quantites.*' => 'required|numeric|min:1',
        'prix_unitaire_ht.*' => 'required|numeric|min:0',
        'tva.*' => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request) {
        $bonCommande = BonCommande::create([
            'fournisseur_id' => $request->fournisseur_id,
            'date_commande' => $request->date_commande,
            'statut' => $request->statut,
            'total_ht' => 0,
            'total_ttc' => 0,
        ]);

        $totalHt = 0;
        $totalTtc = 0;

        foreach ($request->references as $index => $reference) {
            $ligneHt = $request->prix_unitaire_ht[$index] * $request->quantites[$index];
            $ligneTtc = $ligneHt * (1 + $request->tva[$index] / 100);

            BonCommandeDetail::create([
                'bon_commande_id' => $bonCommande->id,
                'reference_produit' => $reference,
                'quantite' => $request->quantites[$index],
                'prix_unitaire_ht' => $request->prix_unitaire_ht[$index],
                'tva' => $request->tva[$index],
                'total_ligne_ht' => $ligneHt,
                'total_ligne_ttc' => $ligneTtc,
            ]);

            $totalHt += $ligneHt;
            $totalTtc += $ligneTtc;
        }

        $bonCommande->update([
            'total_ht' => $totalHt,
            'total_ttc' => $totalTtc,
        ]);
    });


    return redirect()->route('bons-commande.index')
        ->with('success', 'Bon de commande créé avec succès.');
    
}



  


    public function print(BonCommande $bonCommande)
    {
        $bonCommande->load('details.produit'); // Load details and associated products (designation and tva)
        $pdf = Pdf::loadView('bons-commande.pdf', compact('bonCommande'));

        // Optionally, customize the filename
        $filename = 'bon_commande_' . $bonCommande->numero_bc . '.pdf';

        return $pdf->download($filename); // Download the PDF
    }

    public function show($id)
{
    abort(404); // Optionnel : tu peux afficher une erreur 404
}


    public function destroy($id)
{
    // Trouver le bon de commande
    $bonCommande = BonCommande::findOrFail($id);

    // Supprimer les détails associés
    $bonCommande->details()->delete();

    // Supprimer le bon de commande principal
    $bonCommande->delete();

    // Redirection avec un message de succès
    return redirect()->route('bons-commande.index')
        ->with('success', 'Bon de commande supprimé avec succès.');
}


    public function edit($id)
    {
        $bonCommande = BonCommande::findOrFail($id);
        $fournisseurs = Fournisseur::all();
        $produits = Produit::all();

        return view('bons-commande.edit', compact('bonCommande', 'fournisseurs', 'produits'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'fournisseur_id' => 'required|exists:fournisseurs,id',
        'date_commande' => 'required|date',
        'statut' => 'required|in:en_attente,valide,annule',
        'references' => 'required|array|min:1', // Assure que references est un tableau non vide
        'references.*' => 'required|exists:produits,reference', // Vérifie chaque référence
        'quantites' => 'required|array|min:1', // Assure que quantites est un tableau non vide
        'quantites.*' => 'required|numeric|min:1', // Vérifie chaque quantité
        'prix_unitaire_ht' => 'required|array|min:1', // Assure que prix_unitaire_ht est un tableau non vide
        'prix_unitaire_ht.*' => 'required|numeric|min:0', // Vérifie chaque prix
        'tva' => 'required|array|min:1', // Assure que tva est un tableau non vide
        'tva.*' => 'required|in:7,10,20', // Vérifie chaque taux de TVA
    ]);

    try {
        DB::transaction(function () use ($request, $id) {
            $bonCommande = BonCommande::findOrFail($id);

            // Mise à jour des informations de la commande
            $bonCommande->update([
                'fournisseur_id' => $request->fournisseur_id,
                'date_commande' => $request->date_commande,
                'statut' => $request->statut,
            ]);

            // Supprimer les anciens détails de la commande
            $bonCommande->details()->delete();

            $totalHt = 0;
            $totalTtc = 0;

            // Ajouter ou mettre à jour les nouveaux détails
            foreach ($request->references as $index => $reference) {
                $ligneHt = $request->prix_unitaire_ht[$index] * $request->quantites[$index];
                $ligneTtc = $ligneHt * (1 + $request->tva[$index] / 100);

                BonCommandeDetail::create([
                    'bon_commande_id' => $bonCommande->id,
                    'reference_produit' => $reference,
                    'quantite' => $request->quantites[$index],
                    'prix_unitaire_ht' => $request->prix_unitaire_ht[$index],
                    'tva' => $request->tva[$index],
                    'total_ligne_ht' => $ligneHt,
                    'total_ligne_ttc' => $ligneTtc,
                ]);

                // Mise à jour des totaux
                $totalHt += $ligneHt;
                $totalTtc += $ligneTtc;
            }

            // Mise à jour des totaux dans le bon de commande
            $bonCommande->update([
                'total_ht' => $totalHt,
                'total_ttc' => $totalTtc,
            ]);
        });

        // Redirection après succès
        return redirect()->route('bons-commande.index')
            ->with('success', 'Bon de commande mis à jour avec succès.');
    } catch (\Exception $e) {
        // Retourner en cas d'erreur avec un message d'erreur
        return redirect()->back()->withErrors('Erreur lors de la mise à jour : ' . $e->getMessage());
    }
}


}
