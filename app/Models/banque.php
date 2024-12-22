<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    use HasFactory;

    // Spécifier les champs qui peuvent être remplis (mass assignment)
    protected $fillable = [
        'nom',
        'adresse',
        'rib',
        'solde',
    ];
    public function identifiants()
    {
        return $this->hasMany(Identifiant::class);
    }
}
