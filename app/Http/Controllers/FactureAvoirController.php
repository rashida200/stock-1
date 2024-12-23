<?php

namespace App\Http\Controllers;

use App\Models\BonAvoir;
use App\Models\FactureAvoir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureAvoirController extends Controller
{

    public function print(FactureAvoir $factureAvoir)
{
    try {
        $factureAvoir->load([
            'bonAvoir',
            'bonAvoir.client',
            'bonAvoir.details.produit',
            'bonAvoir.bonLivraison'
        ]);

        // Configure PDF options
        $pdf = PDF::loadView('factures-avoir.print', compact('factureAvoir'));

        // Set paper to A4
        $pdf->setPaper('a4');

        // Set other PDF options if needed
        $pdf->setOptions([
            'isPhpEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150,
            'defaultFont' => 'arial'
        ]);

        // Return the PDF for download
        return $pdf->download('facture_avoir_' . $factureAvoir->numero_facture_avoir . '.pdf');
    } catch (\Exception $e) {
        Log::error('Error generating Facture Avoir PDF: ' . $e->getMessage());
        return back()->with('error', 'Erreur lors de la génération du PDF: ' . $e->getMessage());
    }
}
    public function index()
    {
        $facturesAvoir = FactureAvoir::with(['bonAvoir.client'])
            ->latest()
            ->paginate(10);

        return view('factures-avoir.index', compact('facturesAvoir'));
    }

    public function create(Request $request)
    {
        $bonAvoir = null;
        if ($request->has('bon_avoir')) {
            $bonAvoir = BonAvoir::with(['client', 'bonLivraison', 'details.produit'])
                ->findOrFail($request->bon_avoir);
        }

        $bonsAvoir = BonAvoir::where('statut', 'en_attente')
            ->with(['client', 'bonLivraison'])
            ->get();

        return view('factures-avoir.create', compact('bonsAvoir', 'bonAvoir'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bon_avoir_id' => 'required|exists:bons_avoir,id',
            'date_facture' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $bonAvoir = BonAvoir::with(['bonLivraison'])->findOrFail($request->bon_avoir_id);

            // Verify that the bon d'avoir hasn't been already processed
            if ($bonAvoir->statut !== 'en_attente') {
                throw new \Exception('Ce bon d\'avoir a déjà été traité.');
            }

            $montantOriginalTtc = $bonAvoir->bonLivraison->total_ttc;
            $montantAvoirTtc = $bonAvoir->total_ttc;
            $montantFinalTtc = $montantOriginalTtc - $montantAvoirTtc;

            // Create Facture d'Avoir
            $factureAvoir = FactureAvoir::create([
                'bon_avoir_id' => $bonAvoir->id,
                'date_facture' => $request->date_facture,
                'montant_original_ttc' => $montantOriginalTtc,
                'montant_avoir_ttc' => $montantAvoirTtc,
                'montant_final_ttc' => $montantFinalTtc
            ]);

            // Update Bon d'Avoir status
            $bonAvoir->update(['statut' => 'facturé']);

            DB::commit();

            return redirect()->route('factures-avoir.show', $factureAvoir)
                ->with('success', 'Facture d\'avoir créée avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erreur lors de la création de la facture d\'avoir: ' . $e->getMessage()]);
        }
    }

    public function show($id)  // Changed to accept $id instead of model binding
    {
        try {
            Log::info('Attempting to show FactureAvoir with ID: ' . $id);

            $factureAvoir = FactureAvoir::with([
                'bonAvoir',
                'bonAvoir.client',
                'bonAvoir.details.produit'
            ])->find($id);

            if (!$factureAvoir) {
                Log::error('FactureAvoir not found with ID: ' . $id);
                return redirect()
                    ->route('factures-avoir.index')
                    ->with('error', 'Facture d\'avoir non trouvée.');
            }

            Log::info('FactureAvoir found:', [
                'id' => $factureAvoir->id,
                'numero' => $factureAvoir->numero_facture_avoir,
                'has_bon_avoir' => $factureAvoir->bonAvoir ? 'yes' : 'no'
            ]);

            if (!$factureAvoir->bonAvoir) {
                Log::error('BonAvoir not found for FactureAvoir ID: ' . $id);
                return redirect()
                    ->route('factures-avoir.index')
                    ->with('error', 'Le bon d\'avoir associé est introuvable.');
            }

            return view('factures-avoir.show', compact('factureAvoir'));
        } catch (\Exception $e) {
            Log::error('Exception in FactureAvoir show method: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return redirect()
                ->route('factures-avoir.index')
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }
}
