<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Identifiant;
use Illuminate\Http\Request;
use App\Models\Identification; // Assuming you have a model for this.

class IdentifiantController extends Controller
{
    public function show()
    {
        // Récupérer l'identifiant avec la relation bank
        $identification = Identifiant::with('banques')->first();

        // Vous pouvez modifier la requête des banques selon vos besoins
        // Exemple 1: Trier par nom
        // $banks = Bank::orderBy('nom')->get();

        // Exemple 2: Filtrer par critère
        // $banks = Bank::where('active', true)->get();

        // Exemple 3: Sélectionner certains champs spécifiques
        // $banks = Bank::select('id', 'nom', 'rib', 'adresse')->get();

        // Requête par défaut
        $banks = Banque::all();

        // Créer un nouveau si aucun identifiant n'existe
        if (!$identification) {
            $identification = new Identifiant();
        }

        // Vous pouvez ajouter d'autres variables à passer à la vue ici
        return view('identifiants.index', compact('identification', 'banks'));
    }

    public function save(Request $request)
{
    // Règles de validation
    $validationRules = [
        'company_name' => 'required|string|max:255',
        'company_description' => 'required|string|max:500',
        'location' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone1' => 'required|string|max:15',
        'phone2' => 'nullable|string|max:15',
        'ice' => 'required|string|max:50',
        'rc' => 'required|string|max:50',
        'if' => 'required|string|max:50',
        'patente' => 'required|string|max:50',
        'cnss' => 'required|string|max:50',
        'email' => 'required|email|max:255',
        'banque_id' => 'required|exists:banques,id',
    ];

    // Validation des données
    $validated = $request->validate($validationRules);

    // Récupérer ou créer l'identifiant
    $identification = Identifiant::first() ?? new Identifiant();

    // Récupérer la banque sélectionnée
    $bank = Banque::find($request->banque_id);

    // Combiner les informations de la banque (nom, RIB, adresse)
    $bank_account = "Compte N°: " . $bank->rib . " | " . $bank->nom . " | " . $bank->adresse;

    // Ajouter cette valeur dans les données de l'identifiant
    $validated['bank_account'] = $bank_account;

    // Mettre à jour les champs de l'identifiant
    $identification->fill($validated);

    // Sauvegarder l'identifiant
    $identification->save();

    // Personnaliser le message de succès
    $message = 'Les informations ont été mises à jour avec succès!';

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', $message);
}

}
