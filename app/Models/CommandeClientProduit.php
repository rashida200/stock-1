<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeClientProduit extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_client_id',
        'produit_id',
        'qte_vte',
        'prix_unitaire',
        'tva',
        'montant_ht',
        'montant_ttc',
    ];

    public function commandeClient()
    {
        return $this->belongsTo(CommandeClient::class, 'commande_client_id');
    }

    public function produits()
{
    return $this->belongsToMany(Produit::class, 'commande_client_produits')
                ->withPivot([
                    'qte_vte', 'remise', 'prix_unitaire',
                    'montant_ht', 'tva', 'montant_ttc',
                ]);
}
public function produit()
{
    return $this->belongsTo(Produit::class, 'produit_id');
}
}
