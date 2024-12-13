<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonCommandeDetail extends Model
{
    protected $fillable = [
        'bon_commande_id',
        'reference_produit',
        'quantite',
        'prix_unitaire_ht',
        'tva',
        'total_ligne_ht',
        'total_ligne_ttc'
    ];

    public function bonCommande()
    {
        return $this->belongsTo(BonCommande::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'reference_produit', 'reference');
    }
}
