<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use Illuminate\Http\Request;

class BanqueController extends Controller
{
    // Afficher toutes les banques
    public function index()
    {
        $banques = Banque::all();
        return view('banques.index', compact('banques'));
    }

    // Afficher le formulaire pour créer une nouvelle banque
    public function create()
    {
        return view('banques.create');
    }

    // Enregistrer une nouvelle banque
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'rib' => 'required|string|max:255',
            'solde' => 'required|string|max:255',
        ]);

        Banque::create($request->all());

        return redirect()->route('banques.index')
                         ->with('success', 'Banque créée avec succès.');
    }

    // Afficher une banque spécifique
    public function show($id)
    {
        $banque = Banque::findOrFail($id);
        return view('banques.show', compact('banque'));
    }

    // Afficher le formulaire pour modifier une banque
    public function edit($id)
    {
        $banque = Banque::findOrFail($id);
        return view('banques.edit', compact('banque'));
    }

    // Mettre à jour une banque
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'rib' => 'required|string|max:255',
            'solde' => 'required|string|max:255',
        ]);

        $banque = Banque::findOrFail($id);
        $banque->update($request->all());

        return redirect()->route('banques.index')
                         ->with('success', 'Banque mise à jour avec succès.');
    }

    // Supprimer une banque
    public function destroy($id)
    {
        $banque = Banque::findOrFail($id);
        $banque->delete();

        return redirect()->route('banques.index')
                         ->with('success', 'Banque supprimée avec succès.');
    }
}
