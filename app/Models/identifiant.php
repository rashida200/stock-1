<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identifiant extends Model
{
    use HasFactory;

    // Nom de la table
    protected $table = 'identifiants';

    // Champs modifiables
    protected $fillable = [
        'company_name',
        'banque_id',
        'company_description',
        'location',
        'address',
        'phone1',
        'phone2',
        'ice',
        'rc',
        'if',
        'patente',
        'cnss',
        'email',
        'bank_account',
    ];

    public function banques()
    {
        return $this->belongsTo(Banque::class);
    }
}
