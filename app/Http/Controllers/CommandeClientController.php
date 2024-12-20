<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CommandeClient;
use App\Models\CommandeClientProduit;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommandeClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $commandes = CommandeClient::with('produits','client')
            ->when($search, function($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('date_commande', 'like', "%{$search}%")
                    ->orWhereHas('client', function($query) use ($search) {
                        $query->where('nom', 'like', "%{$search}%");
                    })
                    ->orWhereHas('produits', function($query) use ($search) {
                        $query->where('designation', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        $clients = Client::all();
        $produits = Produit::all();
        $coms = CommandeClientProduit::all();

        return view('commandes.index', compact('commandes', 'produits' ,'clients', 'search', 'coms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $produits = Produit::all();
        return view('commandes.create', compact('clients', 'produits'));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $validated = $request->validate([
             'client_id' => 'required|exists:clients,id',
             'date_commande' => 'required|date',
             'reglement' => 'required|in:Espèce,Chèque,LCTraite,Virement,Prélèvement,En Compte,Délégation de créance',
             'produit_id' => 'required|array|min:1',
             'produit_id.*' => 'required|exists:produits,id',
             'qte_vte' => 'required|array|min:1',
             'qte_vte.*' => 'required|integer|min:1',
             'prix_unitaire' => 'required|array|min:1',
             'prix_unitaire.*' => 'required|numeric|min:0',
             'tva' => 'nullable|array',
             'tva.*' => 'nullable|numeric|min:0',
             'remise' => 'nullable|array',
             'remise.*' => 'nullable|numeric|min:0',
             'statut' => 'required|string|in:en attente,expediée,livree,annulee',
         ]);

         $commande = CommandeClient::create([
             'client_id' => $validated['client_id'],
             'date_commande' => $validated['date_commande'],
             'reglement' => $validated['reglement'],
             'ref_regl' => $request->ref_regl ?? null,
             'statut' => $validated['statut'],
         ]);

         $montantTotalCommande = 0;

         foreach ($validated['produit_id'] as $index => $produitId) {
             $prixUnitaire = $validated['prix_unitaire'][$index];
             $quantite = $validated['qte_vte'][$index];
             $tva = $validated['tva'][$index] ?? 0;
             $remise = $validated['remise'][$index] ?? 0;

             $montantHt = $prixUnitaire * $quantite;
             $montantRemise = $montantHt * ($remise / 100);
             $montantHtRemise = $montantHt - $montantRemise;
             $montantTtc = $montantHtRemise * (1 + ($tva / 100));

             $montantTotalCommande += $montantTtc;

             // Récupérer le produit pour mettre à jour la quantité
             $produit = Produit::findOrFail($produitId);
             if ($produit->quantity < $quantite) {
                 return redirect()->back()->withErrors("La quantité disponible pour le produit {$produit->name} est insuffisante.");
             }

             $produit->quantity -= $quantite;
             $produit->save();

             $commande->produits()->attach($produitId, [
                 'qte_vte' => $quantite,
                 'prix_unitaire' => $prixUnitaire,
                 'remise' => $remise,
                 'tva' => $tva,
                 'montant_ht' => $montantHtRemise, // Ajout après remise
                 'montant_ttc' => $montantTtc,
             ]);
         }

         $commande->montant_total = $montantTotalCommande;
         $commande->save();

         return redirect()->route('commandes.index')->with('success', 'La commande a été créée avec succès et les stocks ont été mis à jour !');
     }





    /**
     * Display the specified resource.
     */

public function show($id)
{
    // Récupération des informations de la commande principale
    $commande = CommandeClient::with('client') // Inclut les informations sur le client
        ->where('id', $id)
        ->first();

    // Vérification si la commande existe
    if (!$commande) {
        abort(404, 'Commande introuvable');
    }

    // Récupération des produits associés à la commande
    $produits = DB::table('commande_client_produits')
        ->join('produits', 'produits.id', '=', 'commande_client_produits.produit_id')
        ->where('commande_client_produits.commande_client_id', $id)
        ->select(
            'produits.designation as nom',
            'commande_client_produits.qte_vte',
            'commande_client_produits.prix_unitaire',
            'commande_client_produits.remise',
            'commande_client_produits.tva',
            'commande_client_produits.montant_ht',
            'commande_client_produits.montant_ttc',
        )
        ->get();

    // Calcul du montant total



    // Return view with the updated total
    return view('commandes.show', [
        'commande' => $commande,
        'produits' => $produits,
    ]);

}


    public function edit($id)
    {
        $commandeClient = CommandeClient::findOrFail($id);
        $clients = Client::all();
        $produits = Produit::all();

        return view('commandes.edit', compact('commandeClient', 'clients', 'produits'));
    }



//     public function update(Request $request, CommandeClient $commande)
// {
//     // Validate the request data
//     $validated = $request->validate([
//         'client_id' => 'required|exists:clients,id',
//         'date_commande' => 'required|date',
//         'reglement' => 'required|in:Espèce,Chèque,LCTraite,Virement,Prélèvement,En Compte,Délégation de créance',
//         'produit_id' => 'required|array|min:1',
//         'produit_id.*' => 'required|exists:produits,id',
//         'qte_vte' => 'required|array|min:1',
//         'qte_vte.*' => 'required|integer|min:1',
//         'prix_unitaire' => 'required|array|min:1',
//         'prix_unitaire.*' => 'required|numeric|min:0',
//         'tva' => 'nullable|array',
//         'tva.*' => 'nullable|numeric|min:0',
//         'remise' => 'nullable|array',
//         'remise.*' => 'nullable|numeric|min:0',
//         'statut' => 'required|string|in:en attente,expediée,livree,annulee',
//     ]);

//     // Update main order information
//     $commande->update([
//         'client_id' => $validated['client_id'],
//         'date_commande' => $validated['date_commande'],
//         'reglement' => $validated['reglement'],
//         'ref_regl' => $request->ref_regl ?? null,
//         'statut' => $validated['statut'],
//     ]);

//     // Reset total amount
//     $montantTotalCommande = 0;

//     // Synchronize products
//     $productData = [];
//     foreach ($validated['produit_id'] as $index => $produitId) {
//         $prixUnitaire = $validated['prix_unitaire'][$index];
//         $quantite = $validated['qte_vte'][$index];
//         $tva = $validated['tva'][$index] ?? 0;
//         $remise = $validated['remise'][$index] ?? 0;

//         // Calculate pricing
//         $montantHt = $prixUnitaire * $quantite;
//         $montantRemise = $montantHt * ($remise / 100);
//         $montantHtRemise = $montantHt - $montantRemise;
//         $montantTtc = $montantHtRemise * (1 + ($tva / 100));

//         // Accumulate total amount
//         $montantTotalCommande += $montantTtc;

//         // Prepare product data for synchronization
//         $productData[$produitId] = [
//             'qte_vte' => $quantite,
//             'prix_unitaire' => $prixUnitaire,
//             'remise' => $remise,
//             'tva' => $tva,
//             'montant_ht' => $montantHtRemise,
//             'montant_ttc' => $montantTtc,
//         ];
//     }

//     // Update pivot table with new product data
//     $commande->produits()->sync($productData);

//     // Update total amount for the order
//     $commande->update(['montant_total' => $montantTotalCommande]);

//     return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès!');
// }
public function update(Request $request, CommandeClient $commande)
{
    // Validate the request data
    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'date_commande' => 'required|date',
        'reglement' => 'required|in:Espèce,Chèque,LCTraite,Virement,Prélèvement,En Compte,Délégation de créance',
        'produit_id' => 'required|array|min:1',
        'produit_id.*' => 'required|exists:produits,id',
        'qte_vte' => 'required|array|min:1',
        'qte_vte.*' => 'required|integer|min:1',
        'prix_unitaire' => 'required|array|min:1',
        'prix_unitaire.*' => 'required|numeric|min:0',
        'tva' => 'nullable|array',
        'tva.*' => 'nullable|numeric|min:0',
        'remise' => 'nullable|array',
        'remise.*' => 'nullable|numeric|min:0',
        'statut' => 'required|string|in:en attente,expediée,livree,annulee',
    ]);

    // Update main order information
    $commande->update([
        'client_id' => $validated['client_id'],
        'date_commande' => $validated['date_commande'],
        'reglement' => $validated['reglement'],
        'ref_regl' => $request->ref_regl ?? null,
        'statut' => $validated['statut'],
    ]);

    // Reset total amount
    $montantTotalCommande = 0;

    // Retrieve current product quantities in the order
    $currentProducts = $commande->produits()->pluck('qte_vte', 'produit_id');

    // Synchronize products
    $productData = [];
    foreach ($validated['produit_id'] as $index => $produitId) {
        $prixUnitaire = $validated['prix_unitaire'][$index];
        $quantite = $validated['qte_vte'][$index];
        $tva = $validated['tva'][$index] ?? 0;
        $remise = $validated['remise'][$index] ?? 0;

        // Calculate pricing
        $montantHt = $prixUnitaire * $quantite;
        $montantRemise = $montantHt * ($remise / 100);
        $montantHtRemise = $montantHt - $montantRemise;
        $montantTtc = $montantHtRemise * (1 + ($tva / 100));

        // Accumulate total amount
        $montantTotalCommande += $montantTtc;

        // Adjust stock based on the difference in quantities
        $produit = Produit::findOrFail($produitId);
        $oldQuantity = $currentProducts[$produitId] ?? 0;
        $quantityDifference = $quantite - $oldQuantity;

        if ($produit->quantity < $quantityDifference) {
            return redirect()->back()->withErrors("La quantité disponible pour le produit {$produit->name} est insuffisante.");
        }

        $produit->quantity -= $quantityDifference;
        $produit->save();

        // Prepare product data for synchronization
        $productData[$produitId] = [
            'qte_vte' => $quantite,
            'prix_unitaire' => $prixUnitaire,
            'remise' => $remise,
            'tva' => $tva,
            'montant_ht' => $montantHtRemise,
            'montant_ttc' => $montantTtc,
        ];
    }

    // Update pivot table with new product data
    $commande->produits()->sync($productData);

    // Update total amount for the order
    $commande->update(['montant_total' => $montantTotalCommande]);

    return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès et les stocks ont été ajustés !');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommandeClient $commandeClient)
    {
        //
    }
}
