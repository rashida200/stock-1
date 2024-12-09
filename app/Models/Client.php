<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'type', 'cin', 'lice', 'telephone',
        'adresse', 'adresse_projet', 'nombre_hectare'
    ];
}
