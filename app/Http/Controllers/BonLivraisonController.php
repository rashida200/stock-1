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
        // Valider les données entrantes
        $validatedData = $request->validate([
            'commande_id' => 'required|integer',
            'client_id' => 'required|integer',
            'client_nom' => 'required|string',
            'client_telephone' => 'required|string',
            'date_vente' => 'required|date',
            'date_livraison' => 'required|date',
            'produits' => 'required|json',
        ]);

        // Décoder les produits
        $produits = json_decode($validatedData['produits'], true);

        // Vérifier que les produits sont valides
        if (!is_array($produits)) {
            return response()->json(['error' => 'Les produits doivent être un tableau JSON valide.'], 400);
        }

        // Calculer total_ht et total_ttc
        $total_ht = 0;
        $total_ttc = 0;
        foreach ($produits as $produit) {
            $total_ht += $produit['total_ligne_ht'];
            $total_ttc += $produit['total_ligne_ttc'];
        }

        // Créer le bon de livraison avec total_ht, total_ttc, et statut
        $bonLivraison = BonLivraison::create([
            'commande_id' => $validatedData['commande_id'],
            'client_id' => $validatedData['client_id'],
            'client_nom' => $validatedData['client_nom'],
            'client_telephone' => $validatedData['client_telephone'],
            'date_vente' => $validatedData['date_vente'],
            'date_livraison' => $validatedData['date_livraison'],
            'total_ht' => $total_ht,
            'total_ttc' => $total_ttc,
            'statut' => 'expidée',  // Valeur par défaut pour statut
        ]);

        // Insérer les détails des produits
        foreach ($produits as $produit) {
            BonLivraisonDetail::create([
                'bon_livraison_id' => $bonLivraison->id, // Associer au bon de livraison créé
                'produit_id' => $produit['produit_id'],
                'quantite' => $produit['quantite'],
                'prix_unitaire_ht' => $produit['prix_unitaire_ht'],
                'total_ligne_ht' => $produit['total_ligne_ht'],
                'tva' => $produit['tva'],
                'total_ligne_ttc' => $produit['total_ligne_ttc'],
            ]);
        }

        return redirect(route('bons-livraison.index'));
    }





    public function print(BonLivraison $bonLivraison)
    {
        // Ensure all necessary relationships are loaded
        $bonLivraison->load('details.produit');

        $pdf = Pdf::loadView('bons-livraison.pdf', compact('bonLivraison'));

        $filename = 'bon_livraison_' . $bonLivraison->numero_bl . '.pdf';

        return $pdf->download($filename);
    }


    public function edit($id)
    {
        $bonLivraison = BonLivraison::findOrFail($id);
        $clients = Client::all();
        $produits = Produit::all();
        // Added this line to match create logic
        $commandes = CommandeClient::where('statut', 'expediée')->with('commandeClientProduits.produit')->get();

        return view('bons-livraison.edit', compact('bonLivraison', 'clients', 'produits', 'commandes'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_vente' => 'required|date',
            'date_livraison' => 'required|date|after_or_equal:date_vente',
        ]);

        DB::transaction(function () use ($request, $id) {
            $bonLivraison = BonLivraison::findOrFail($id);

            // Get the data from form
            $quantites = $request->input('quantites', []);
            $prixUnitaires = $request->input('prix_unitaire_ht', []);
            $tvas = $request->input('tva', []);

            // Get current details
            $details = $bonLivraison->details;

            // Prepare products array
            $produits = [];
            foreach ($details as $index => $detail) {
                // Calculate new totals
                $quantite = $quantites[$index] ?? $detail->quantite;
                $prixUnitaireHt = $prixUnitaires[$index] ?? $detail->prix_unitaire_ht;
                $tva = $tvas[$index] ?? $detail->tva;

                $totalLigneHt = $quantite * $prixUnitaireHt;
                $totalLigneTtc = $totalLigneHt * (1 + ($tva / 100));

                $produits[] = [
                    'produit_id' => $detail->produit_id,
                    'quantite' => $quantite,
                    'prix_unitaire_ht' => $prixUnitaireHt,
                    'total_ligne_ht' => $totalLigneHt,
                    'tva' => $tva,
                    'total_ligne_ttc' => $totalLigneTtc,
                ];
            }

            // Calculate totals
            $totalHt = array_sum(array_column($produits, 'total_ligne_ht'));
            $totalTtc = array_sum(array_column($produits, 'total_ligne_ttc'));

            // Update Bon de Livraison
            $bonLivraison->update([
                'client_id' => $request->client_id,
                'date_vente' => $request->date_vente,
                'date_livraison' => $request->date_livraison,
                'total_ht' => $totalHt,
                'total_ttc' => $totalTtc,
            ]);

            // Delete old details
            $bonLivraison->details()->delete();

            // Create new details
            foreach ($produits as $produit) {
                BonLivraisonDetail::create([
                    'bon_livraison_id' => $bonLivraison->id,
                    'produit_id' => $produit['produit_id'],
                    'quantite' => $produit['quantite'],
                    'prix_unitaire_ht' => $produit['prix_unitaire_ht'],
                    'total_ligne_ht' => $produit['total_ligne_ht'],
                    'tva' => $produit['tva'],
                    'total_ligne_ttc' => $produit['total_ligne_ttc'],
                ]);
            }
        });

        return redirect()->route('bons-livraison.index')
        ->with('success', 'Bon de livraison mis à jour avec succès.');
    }
}
