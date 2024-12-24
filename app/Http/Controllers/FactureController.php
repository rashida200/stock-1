<?php
// app/Http/Controllers/FactureController.php
namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\BonLivraison;
use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with('client')->latest()->paginate(10);
        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        $clients = Client::all();
        $bonsLivraison = BonLivraison::whereDoesntHave('factures')
                                    ->where('statut', 'expidée')
                                    ->get()
                                    ->groupBy('client_id');
        return view('factures.create', compact('clients', 'bonsLivraison'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_facture' => 'required|date',
            'bons_livraison' => 'required|array',
            'bons_livraison.*' => 'exists:bons_livraison,id'
        ]);

        $bonsLivraison = BonLivraison::whereIn('id', $validated['bons_livraison'])->get();

        $totalHt = $bonsLivraison->sum('total_ht');
        $totalTtc = $bonsLivraison->sum('total_ttc');

        $facture = Facture::create([
            'client_id' => $validated['client_id'],
            'date_facture' => $validated['date_facture'],
            'total_ht' => $totalHt,
            'total_ttc' => $totalTtc,
            'statut' => 'en_attente'
        ]);

        $facture->bonsLivraison()->attach($validated['bons_livraison']);

        return redirect()->route('factures.index')
                        ->with('success', 'Facture créée avec succès.');
    }

    public function print(Facture $facture)
    {
        $facture->load('bonsLivraison.details.produit');

        $pdf = PDF::loadView('factures.pdf', compact('facture'));

        return $pdf->download('facture_' . $facture->numero_facture . '.pdf');
    }
    public function printlogo(Facture $facture)
    {
        $facture->load('bonsLivraison.details.produit');

        $pdf = PDF::loadView('factures.printlogo', compact('facture'));

        return $pdf->download('facture_' . $facture->numero_facture . '.pdf');
    }

    public function edit(Facture $facture)
    {
        $clients = Client::all();
        $currentBonsLivraison = $facture->bonsLivraison->pluck('id')->toArray();
        $availableBonsLivraison = BonLivraison::where('client_id', $facture->client_id)
            ->where(function($query) use ($currentBonsLivraison) {
                $query->whereDoesntHave('factures')
                      ->orWhereIn('id', $currentBonsLivraison);
            })
            ->get();

        return view('factures.edit', compact('facture', 'clients', 'availableBonsLivraison'));
    }

    public function update(Request $request, Facture $facture)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_facture' => 'required|date',
            'bons_livraison' => 'required|array',
            'bons_livraison.*' => 'exists:bons_livraison,id'
        ]);

        $bonsLivraison = BonLivraison::whereIn('id', $validated['bons_livraison'])->get();

        $totalHt = $bonsLivraison->sum('total_ht');
        $totalTtc = $bonsLivraison->sum('total_ttc');

        $facture->update([
            'client_id' => $validated['client_id'],
            'date_facture' => $validated['date_facture'],
            'total_ht' => $totalHt,
            'total_ttc' => $totalTtc
        ]);

        $facture->bonsLivraison()->sync($validated['bons_livraison']);

        return redirect()->route('factures.index')
                        ->with('success', 'Facture mise à jour avec succès.');
    }
}
