<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonLivraisonDetail extends Model
{
    protected $fillable = [
        'bon_livraison_id',
        'produit_id',
        'reference_produit',
        'quantite',
        'prix_unitaire_ht',
        'tva',
        'total_ligne_ht',
        'total_ligne_ttc'
    ];

    public function bonLivraison() {
        return $this->belongsTo(BonLivraison::class, 'bon_livraison_id');
    }

    public function produit() {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
