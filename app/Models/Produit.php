<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'designation',
        'quantity',
        'prix_achat_ht',
        'tva',
        'prix_achat_ttc',
        'prix_vente',
        'total_ht',
        'total_ttc',
        'fournisseur_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produit) {
            if (empty($produit->reference)) {
                $produit->reference = '1-' . str_pad(Produit::max('id') + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function commandes()
{
    return $this->belongsToMany(CommandeClient::class, 'commande_client_produits')
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
}
