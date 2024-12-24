<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\DevisDetail;
use App\Models\Client;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Container\Attributes\DB as AttributesDB;
use Illuminate\Support\Facades\DB as FacadesDB;

class DevisController extends Controller
{
    public function create()
    {
        $clients = Client::all();
        $produits = Produit::all();
        return view('devis.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
    {
        // Validation des données entrantes
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_devis' => 'required|date',
            'references' => 'required|array',
            'references.*' => 'required|string',
            'quantites' => 'required|array',
            'quantites.*' => 'required|integer|min:1',
            'prix_unitaire_ht' => 'required|array',
            'prix_unitaire_ht.*' => 'required|numeric|min:0',
            'tva' => 'required|array',
            'tva.*' => 'required|numeric|min:0|max:100',
            'statut' => 'required|in:en_attente,accepté,refusé',
        ]);

        // Transaction pour garantir l'intégrité des données
        DB::transaction(function () use ($validated) {
            // Créer le devis
            $devis = Devis::create([
                'client_id' => $validated['client_id'],
                'date_devis' => $validated['date_devis'],
                'statut' => $validated['statut'],
            ]);

            $total_ht = 0;
            $total_ttc = 0;

            foreach ($validated['references'] as $key => $reference) {
                $quantite = $validated['quantites'][$key];
                $prix_unitaire_ht = $validated['prix_unitaire_ht'][$key];
                $tva = $validated['tva'][$key];

                $total_ligne_ht = $quantite * $prix_unitaire_ht;
                $total_ligne_ttc = $total_ligne_ht * (1 + $tva / 100);

                $total_ht += $total_ligne_ht;
                $total_ttc += $total_ligne_ttc;

                // Créer le détail du devis
                DevisDetail::create([
                    'devis_id' => $devis->id,
                    'produit_id' => $reference, // Supposant que 'reference' correspond à un produit existant
                    'quantite' => $quantite,
                    'prix_unitaire_ht' => $prix_unitaire_ht,
                    'tva' => $tva,
                    'total_ligne_ht' => $total_ligne_ht,
                    'total_ligne_ttc' => $total_ligne_ttc,
                ]);
            }

            // Mettre à jour les totaux dans le devis
            $devis->update([
                'total_ht' => $total_ht,
                'total_ttc' => $total_ttc,
            ]);
        });

        // Redirection après la réussite
        return redirect()->route('devis.index')->with('success', 'Devis créé avec succès.');
    }

    public function edit($id)
    {
        $devis = Devis::findOrFail($id);
        $clients = Client::all();
        $produits = Produit::all();

        return view('devis.edit', compact('devis', 'clients', 'produits'));
    }



    public function index()
    {
        $devis = Devis::with('client')->latest()->paginate(10);
        return view('devis.index', compact('devis'));
    }

    public function print($id)
    {
        $devis = Devis::with(['client', 'details.produit'])->findOrFail($id);

        $totalHt = $devis->details->sum('total_ligne_ht');
        $totalTtc = $devis->details->sum('total_ligne_ttc');

        $pdf = Pdf::loadView('devis.print', compact('devis', 'totalHt', 'totalTtc'));

        return $pdf->stream("devis_{$devis->id}.pdf");
    }
    public function printlogo($id)
    {
        $devis = Devis::with(['client', 'details.produit'])->findOrFail($id);

        $totalHt = $devis->details->sum('total_ligne_ht');
        $totalTtc = $devis->details->sum('total_ligne_ttc');

        $pdf = Pdf::loadView('devis.printlogo', compact('devis', 'totalHt', 'totalTtc'));

        return $pdf->stream("devis_{$devis->id}.pdf");
    }

    public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'date_devis' => 'required|date',
        'references' => 'required|array|min:1',
        'references.*' => 'required|exists:produits,reference',
        'quantites' => 'required|array|min:1',
        'quantites.*' => 'required|numeric|min:1',
        'prix_unitaire_ht' => 'required|array|min:1',
        'prix_unitaire_ht.*' => 'required|numeric|min:0',
        'tva' => 'required|array|min:1',
        'tva.*' => 'required|numeric|in:7,10,20',
        'statut' => 'required|in:accepté,refusé',
    ]);

    DB::transaction(function () use ($request, $id) {
        // Retrieve the existing "devis" from the database
        $devis = Devis::findOrFail($id);

        // Update the devis details
        $devis->update([
            'client_id' => $request->client_id,
            'date_devis' => $request->date_devis,
            'statut' => $request->statut,
            'total_ht' => 0,  // Will recalculate
            'total_ttc' => 0, // Will recalculate
        ]);

        // Delete existing devis details before updating
        $devis->details()->delete();

        $totalHt = 0;
        $totalTtc = 0;

        // Add the new products to the devis details
        foreach ($request->references as $index => $reference) {
            $produit = Produit::where('reference', $reference)->firstOrFail();

            $ligneHt = $request->prix_unitaire_ht[$index] * $request->quantites[$index];
            $ligneTtc = $ligneHt * (1 + $request->tva[$index] / 100);

            // Create or update the DevisDetail record
            DevisDetail::create([
                'devis_id' => $devis->id,
                'produit_id' => $produit->id,
                'quantite' => $request->quantites[$index],
                'prix_unitaire_ht' => $request->prix_unitaire_ht[$index],
                'tva' => $request->tva[$index],
                'total_ligne_ht' => $ligneHt,
                'total_ligne_ttc' => $ligneTtc,
            ]);

            $totalHt += $ligneHt;
            $totalTtc += $ligneTtc;
        }

        // Update the totals in the Devis record
        $devis->update([
            'total_ht' => $totalHt,
            'total_ttc' => $totalTtc,
        ]);
    });

    return redirect()->route('devis.index')->with('success', 'Devis mis à jour avec succès.');
}

}
