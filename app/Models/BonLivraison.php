<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BonLivraison extends Model
{
    protected $table = 'bons_livraison';

    protected $fillable = [
        'numero_bl',
        'client_id',
        'commande_id',
        'date_vente',
        'date_livraison',
        'total_ht',
        'total_ttc',
        'statut',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bonLivraison) {
            if (empty($bonLivraison->numero_bl)) {
                $bonLivraison->numero_bl = 'BL-' . date('Y') . '-' . str_pad(BonLivraison::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    
    public function commande(): BelongsTo
    {
        return $this->belongsTo(CommandeClient::class);
    }

    public function details()
{
    return $this->hasMany(BonLivraisonDetail::class, 'bon_livraison_id', 'id');
}
}
