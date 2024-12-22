<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', ''); // Get the search term from the query string
        $clients = Client::when($search, function ($query, $search) {
            return $query->where('nom', 'like', '%' . $search . '%')
                ->orWhere('cin', 'like', '%' . $search . '%')
                ->orWhere('lice', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('clients.index', compact('clients', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:personne,entreprise',
            'cin' => 'nullable|string|max:20',
            'lice' => 'nullable|string|max:50',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'adresse_projet' => 'nullable|string|max:255',
            'nombre_hectare' => 'nullable|numeric',
        ]);

        // Remove 'CIN' and 'LICE' prefixes before saving
        $cin = str_replace('CIN', '', $request->cin);
        $lice = str_replace('LICE', '', $request->lice);

        // Create the client with stripped cin and lice
        Client::create([
            'nom' => $request->nom,
            'type' => $request->type,
            'cin' => $cin,
            'lice' => $lice,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'adresse_projet' => $request->adresse_projet,
            'nombre_hectare' => $request->nombre_hectare,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:personne,entreprise',
            'cin' => 'nullable|string|max:20',
            'lice' => 'nullable|string|max:50',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'adresse_projet' => 'nullable|string|max:255',
            'nombre_hectare' => 'nullable|numeric',
        ]);

        // Remove 'CIN' and 'LICE' prefixes before updating
        $cin = str_replace('CIN', '', $request->cin);
        $lice = str_replace('LICE', '', $request->lice);

        // Update the client with stripped cin and lice
        $client->update([
            'nom' => $request->nom,
            'type' => $request->type,
            'cin' => $cin,
            'lice' => $lice,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'adresse_projet' => $request->adresse_projet,
            'nombre_hectare' => $request->nombre_hectare,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }
    public function historique(Client $client)
    {
    // Récupérer tous les devis, bons de livraison et factures pour ce client
    $devis = $client->devis()->get();
    $bonsLivraison = $client->bonsLivraison()->get();
    $factures = $client->factures()->get();

    // Retourner une vue avec les données
    return view('clients.historique', compact('client', 'devis', 'bonsLivraison', 'factures'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->to(url()->previous())->with('success', 'Client supprimé avec succès.');
    }
}
