<?php

namespace App\Http\Controllers;

use App\Models\BonAvoir;
use App\Models\BonAvoirDetail;
use App\Models\BonLivraison;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BonAvoirController extends Controller
{
    public function index()
    {
        $bonsAvoir = BonAvoir::with(['client', 'bonLivraison'])->latest()->paginate(10);
        return view('bons-avoir.index', compact('bonsAvoir'));
    }

    public function create()
    {
        $bonsLivraison = BonLivraison::where('statut', 'expidée')
            ->with(['client', 'details.produit'])
            ->get();
        return view('bons-avoir.create', compact('bonsLivraison'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bon_livraison_id' => 'required|exists:bons_livraison,id',
            'client_id' => 'required|exists:clients,id',
            'date_avoir' => 'required|date',
            'motif' => 'required|string',
            'produits' => 'required|array',
            'produits.*.produit_id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'produits.*.prix_unitaire_ht' => 'required|numeric|min:0',
            'produits.*.tva' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Calculate totals before creating BonAvoir
            $totalHt = 0;
            $totalTtc = 0;

            foreach ($request->produits as $produitData) {
                $totalLigneHt = $produitData['quantite'] * $produitData['prix_unitaire_ht'];
                $totalLigneTtc = $totalLigneHt * (1 + ($produitData['tva'] / 100));

                $totalHt += $totalLigneHt;
                $totalTtc += $totalLigneTtc;
            }

            // Create Bon d'Avoir with totals
            $bonAvoir = BonAvoir::create([
                'bon_livraison_id' => $validatedData['bon_livraison_id'],
                'client_id' => $validatedData['client_id'],
                'date_avoir' => $validatedData['date_avoir'],
                'motif' => $validatedData['motif'],
                'total_ht' => $totalHt,
                'total_ttc' => $totalTtc,
                'statut' => 'en_attente'
            ]);

            // Process each product and create details
            foreach ($request->produits as $produitId => $produitData) {
                if ($produitData['quantite'] > 0) {
                    $produit = Produit::findOrFail($produitData['produit_id']);

                    $totalLigneHt = $produitData['quantite'] * $produitData['prix_unitaire_ht'];
                    $totalLigneTtc = $totalLigneHt * (1 + ($produitData['tva'] / 100));

                    // Create detail record
                    BonAvoirDetail::create([
                        'bon_avoir_id' => $bonAvoir->id,
                        'produit_id' => $produitData['produit_id'],
                        'quantite' => $produitData['quantite'],
                        'prix_unitaire_ht' => $produitData['prix_unitaire_ht'],
                        'tva' => $produitData['tva'],
                        'total_ligne_ht' => $totalLigneHt,
                        'total_ligne_ttc' => $totalLigneTtc,
                    ]);

                    // Update product stock
                    $produit->increment('quantity', $produitData['quantite']);
                }
            }

            DB::commit();
            return redirect()->route('bons-avoir.index')
                ->with('success', 'Bon d\'avoir créé avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création du bon d\'avoir: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $bonAvoir = BonAvoir::with([
                'client',
                'bonLivraison',
                'details.produit',
                'factureAvoir'
            ])->findOrFail($id);

            Log::info('Showing Bon Avoir:', [
                'id' => $bonAvoir->id,
                'numero' => $bonAvoir->numero_ba,
                'client' => $bonAvoir->client->nom ?? 'N/A'
            ]);

            return view('bons-avoir.show', compact('bonAvoir'));

        } catch (\Exception $e) {
            Log::error('Error showing Bon Avoir: ' . $e->getMessage());
            return redirect()
                ->route('bons-avoir.index')
                ->with('error', 'Une erreur est survenue lors de l\'affichage du bon d\'avoir: ' . $e->getMessage());
        }
    }

    public function print(BonAvoir $bonAvoir)
    {
        $pdf = Pdf::loadView('bons-avoir.pdf', compact('bonAvoir'));
        return $pdf->download('bon_avoir_' . $bonAvoir->numero_ba . '.pdf');
    }

    public function printlogo(BonAvoir $bonAvoir)
    {
        $pdf = Pdf::loadView('bons-avoir.printlogo', compact('bonAvoir'));
        return $pdf->download('bon_avoir_' . $bonAvoir->numero_ba . '.pdf');
    }
}
