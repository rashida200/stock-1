<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devis_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devis_id')->constrained()->onDelete('cascade'); // Foreign key for devis
            $table->foreignId('produit_id')->constrained()->onDelete('cascade'); // Foreign key for produit
            $table->integer('quantite');
            $table->decimal('prix_unitaire_ht', 10, 2); // Price of the product (HT)
            $table->decimal('tva', 5, 2); // VAT percentage (e.g., 2, 7, 10)
            $table->decimal('total_ligne_ht', 10, 2); // Total HT per line
            $table->decimal('total_ligne_ttc', 10, 2); // Total TTC per line
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis_details');
    }
};
