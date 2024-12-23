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
        // Create bons_avoir table
        Schema::create('bons_avoir', function (Blueprint $table) {
            $table->id();
            $table->string('numero_ba')->unique();
            $table->foreignId('bon_livraison_id')->constrained('bons_livraison')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->date('date_avoir');
            $table->decimal('total_ht', 15, 2);
            $table->decimal('total_ttc', 15, 2);
            $table->string('motif');
            $table->string('statut')->default('en_attente'); // en_attente, validé, facturé
            $table->timestamps();
        });

        // Create bon_avoir_details table
        Schema::create('bon_avoir_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_avoir_id')->constrained('bons_avoir')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->integer('quantite');
            $table->decimal('prix_unitaire_ht', 10, 2);
            $table->enum('tva', ['7', '10', '20']);
            $table->decimal('total_ligne_ht', 15, 2);
            $table->decimal('total_ligne_ttc', 15, 2);
            $table->timestamps();
        });

        // Create factures_avoir table
        Schema::create('factures_avoir', function (Blueprint $table) {
            $table->id();
            $table->string('numero_facture_avoir')->unique();
            $table->foreignId('bon_avoir_id')->constrained('bons_avoir')->onDelete('cascade');
            $table->date('date_facture');
            $table->decimal('montant_original_ttc', 15, 2);
            $table->decimal('montant_avoir_ttc', 15, 2);
            $table->decimal('montant_final_ttc', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bons_avoir');
    }
};
