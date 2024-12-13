<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BonCommande extends Model
{
    protected $table = 'bons_commande';

    protected $fillable = [
        'numero_bc',
        'fournisseur_id',
        'date_commande',
        'total_ht',
        'total_ttc',
        'statut'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bonCommande) {
            if (empty($bonCommande->numero_bc)) {
                $bonCommande->numero_bc = 'BC-' . date('Y') . '-' . str_pad(BonCommande::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(BonCommandeDetail::class);
    }

   
}
