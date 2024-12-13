<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'date_devis', 'total_ht', 'total_ttc', 'statut'];

    public function client()
    {
        return $this->belongsTo(Client::class); // Assuming a Client model exists
    }

    public function details()
    {
        return $this->hasMany(DevisDetail::class); // Devis details relation
    }
}
