<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = [
        'numero_facture',
        'client_id',
        'date_facture',
        'total_ht',
        'total_ttc',
        'statut'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facture) {
            if (empty($facture->numero_facture)) {
                $facture->numero_facture = 'FAC-' . date('Y') . '-' . str_pad(Facture::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function bonsLivraison()
    {
        return $this->belongsToMany(BonLivraison::class, 'facture_bon_livraison')
                    ->withTimestamps();
    }
}
