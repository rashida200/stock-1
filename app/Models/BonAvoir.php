<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BonAvoir extends Model
{
    protected $table = 'bons_avoir';

    protected $fillable = [
        'numero_ba',
        'bon_livraison_id',
        'client_id',
        'date_avoir',
        'total_ht',
        'total_ttc',
        'motif',
        'statut'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bonAvoir) {
            if (empty($bonAvoir->numero_ba)) {
                $bonAvoir->numero_ba = 'BA-' . date('Y') . '-' . str_pad(BonAvoir::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function bonLivraison()
    {
        return $this->belongsTo(BonLivraison::class);
    }

    public function client()
{
    return $this->belongsTo(Client::class);
}

    public function details()
    {
        return $this->hasMany(BonAvoirDetail::class, 'bon_avoir_id');
    }

    public function factureAvoir()
    {
        return $this->hasOne(FactureAvoir::class);
    }
}

class BonAvoirDetail extends Model
{
    protected $fillable = [
        'bon_avoir_id',
        'produit_id',
        'quantite',
        'prix_unitaire_ht',
        'tva',
        'total_ligne_ht',
        'total_ligne_ttc'
    ];

    public function bonAvoir()
    {
        return $this->belongsTo(BonAvoir::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->date_avoir ? Carbon::parse($this->date_avoir)->format('d/m/Y') : 'N/A';
    }
    public function details()
    {
        return $this->hasMany(BonAvoirDetail::class, 'bon_avoir_id');
    }

    public function factureAvoir()
    {
        return $this->hasOne(FactureAvoir::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }



    // In BonAvoir model

}


