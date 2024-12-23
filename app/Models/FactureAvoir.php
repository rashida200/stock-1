<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FactureAvoir extends Model
{
    protected $table = 'factures_avoir';

    protected $fillable = [
        'numero_facture_avoir',
        'bon_avoir_id',
        'date_facture',
        'montant_original_ttc',
        'montant_avoir_ttc',
        'montant_final_ttc'
    ];

    protected $casts = [
        'date_facture' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $dates = [
        'date_facture',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($factureAvoir) {
            if (empty($factureAvoir->numero_facture_avoir)) {
                $factureAvoir->numero_facture_avoir = 'FA-' . date('Y') . '-' .
                    str_pad(FactureAvoir::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function bonAvoir()
    {
        return $this->belongsTo(BonAvoir::class, 'bon_avoir_id')->withDefault();
    }

    // Calculate the difference between original and final amount
    public function getDifferenceAttribute()
    {
        return $this->montant_original_ttc - $this->montant_final_ttc;
    }

    public function getFormattedDateAttribute()
    {
        return $this->date_facture ? Carbon::parse($this->date_facture)->format('d/m/Y') : 'N/A';
    }
}
