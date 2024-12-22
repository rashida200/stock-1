<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\Facture;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $fournisseurs = Fournisseur::when($search, function ($query, $search) {
            $query->where('nom', 'like', "%$search%")
                ->orWhere('lice', 'like', "%$search%");
        })->paginate(10);

        return view('fournisseurs.index', compact('fournisseurs', 'search'));
    }

    public function history(Fournisseur $fournisseur)
    {
        $bonsCommande =$fournisseur->bonsCommande()->get();

        return view('fournisseurs.history', compact('fournisseur', 'bonsCommande'));
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
            'nom' => 'required',
            'lice' => 'required',
            'telephone' => 'required',
            'rib' => 'required',
        ]);

        Fournisseur::create($request->all());

        return redirect()->back()->with('success', 'Fournisseur added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'lice' => 'required|string|max:255',
            'rib' => 'required|string|max:30',
        ]);

        $fournisseur->update($validatedData);

        return redirect()->route('admin.fournisseurs')->with('success', 'Fournisseur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id); // Find the fournisseur by ID
        $fournisseur->delete(); // Delete the fournisseur

        // Redirect back with a success message
        return redirect()->to(url()->previous())->with('success', 'Fournisseur supprimé avec succès');
    }
}
