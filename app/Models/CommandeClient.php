<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date_commande',
        'reglement',
        'ref_regl',
        'statut',
        'montant_total',
    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    
    public function bon_livr() {
        return $this->belongsTo(BonLivraison::class, 'bonl_id');
    }



    public function produits()
{
    return $this->belongsToMany(Produit::class, 'commande_client_produits')
        ->withPivot([
            'qte_vte',
            'remise',
            'prix_unitaire',
            'montant_ht',
            'tva',
            'montant_ttc',
        ])
        ->withTimestamps();
}
public function commandeClientProduits()
{
    return $this->hasMany(CommandeClientProduit::class);
}
// Dans le modèle
public function formatId()
{
    return sprintf("1-%04d", $this->id);
}

}
