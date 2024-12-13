<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\DevisDetail;
use App\Models\Client;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;

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
            'tva.*' => 'required|numeric|in:2,10,20',
        ]);

        DB::transaction(function () use ($request) {
            // Create the devis
            $devis = Devis::create([
                'client_id' => $request->client_id,
                'date_devis' => $request->date_devis,
                'total_ht' => 0,
                'total_ttc' => 0,
            ]);

            $totalHt = 0;
            $totalTtc = 0;

            // Iterate through products
            foreach ($request->references as $index => $reference) {
                $produit = Produit::where('reference', $reference)->firstOrFail();

                $ligneHt = $request->prix_unitaire_ht[$index] * $request->quantites[$index];
                $ligneTtc = $ligneHt * (1 + $request->tva[$index] / 100);

                // Create DevisDetail
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

            // Update totals in Devis
            $devis->update([
                'total_ht' => $totalHt,
                'total_ttc' => $totalTtc,
            ]);
        });

        return redirect()->route('devis.index')->with('success', 'Devis créé avec succès.');
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
}
