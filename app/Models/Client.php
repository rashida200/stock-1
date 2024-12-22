<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'type', 'cin', 'lice', 'telephone',
        'adresse', 'adresse_projet', 'nombre_hectare'
    ];

    public function clients(): HasMany
    {
        return $this->hasMany(CommandeClient::class);
    }
    public function devis()
    {
        return $this->hasMany(Devis::class);
    }

    // Relation avec les bons de livraison
    public function bonsLivraison()
    {
        return $this->hasMany(BonLivraison::class);
    }

    // Relation avec les factures
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}


