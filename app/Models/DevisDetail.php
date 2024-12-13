<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'devis_id', 'produit_id', 'quantite', 'prix_unitaire_ht', 'tva', 'total_ligne_ht', 'total_ligne_ttc'
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class); // Belongs to Devis
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class); // Belongs to Produit
    }
}
