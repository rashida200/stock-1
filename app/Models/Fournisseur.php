<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fournisseur extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'lice', 'adresse', 'telephone', 'email', 'rib'];

    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class);
    }
}
