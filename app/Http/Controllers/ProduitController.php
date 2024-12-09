<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $produits = Produit::with('fournisseur')
            ->when($search, function ($query, $search) {
                $query->where('reference', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");
            })
            ->paginate(10);

        $fournisseurs = Fournisseur::all();

        return view('produits.index', compact('produits', 'fournisseurs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reference' => 'required|unique:produits,reference',
            'designation' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'prix_achat_ht' => 'required|numeric|min:0',
            'tva' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'fournisseur_id' => 'required|exists:fournisseurs,id', // Ensure the fournisseur exists
        ]);

        // Create a new product
        $produit = new Produit();
        $produit->reference = $request->reference;
        $produit->designation = $request->designation;
        $produit->quantity = $request->quantity;
        $produit->prix_achat_ht = $request->prix_achat_ht;
        $produit->tva = $request->tva;
        $produit->prix_vente = $request->prix_vente;
        $produit->fournisseur_id = $request->fournisseur_id;

        // Save the product
        $produit->save();

        // Redirect with success message
        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'reference' => 'required|unique:produits,reference,' . $id, // Prevent duplicate references
            'designation' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'prix_achat_ht' => 'required|numeric|min:0',
            'tva' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'fournisseur_id' => 'required|exists:fournisseurs,id', // Ensure a valid supplier ID
        ]);

        $produit = Produit::findOrFail($id); // Find the product by ID

        // Update the product data
        $produit->update([
            'reference' => $request->reference,
            'designation' => $request->designation,
            'quantity' => $request->quantity,
            'prix_achat_ht' => $request->prix_achat_ht,
            'tva' => $request->tva,
            'prix_vente' => $request->prix_vente,
            'fournisseur_id' => $request->fournisseur_id,
        ]);

        return back()->with('success', 'Produit mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the product by ID and delete it
        $produit = Produit::findOrFail($id);

        // Delete the product
        $produit->delete();

        // Redirect back to the previous page with a success message
        return redirect()->to(url()->previous())->with('success', 'Produit supprimé avec succès');
    }
}
