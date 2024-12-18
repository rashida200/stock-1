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
            // Récupérer le dernier bon de commande
            $lastBonCommande = BonCommande::whereYear('created_at', date('Y'))
                ->orderBy('created_at', 'desc')
                ->first();

            // Générer le numéro de bon de commande
            $prefix = 'BC-' . date('Y');  // Exemple : 'BC-2024'

            // Si un dernier bon de commande existe, récupérer le dernier numéro
            if ($lastBonCommande) {
                preg_match('/BC-(\d{4})-(\d{4})/', $lastBonCommande->numero_bc, $matches);
                $lastNumber = (int) $matches[2];
                $nextNumber = $lastNumber + 1;
            } else {
                // Si aucun bon de commande n'existe pour cette année, commencer à 0001
                $nextNumber = 1;
            }

            // Générer le numéro de bon de commande
            $bonCommande->numero_bc = $prefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
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
