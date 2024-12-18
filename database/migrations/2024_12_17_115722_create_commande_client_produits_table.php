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
        Schema::create('commande_client_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_client_id')
                ->constrained('commande_clients')
                ->onDelete('cascade');
            $table->foreignId('produit_id')
                ->constrained('produits')
                ->onDelete('cascade');
                $table->integer('qte_vte')->default(1);
                $table->decimal('remise', 5, 2)->nullable();
                $table->decimal('prix_unitaire', 10, 2);
                $table->decimal('montant_ht', 10, 2)->nullable();
                $table->enum('tva', ['7', '10', '20']);
                $table->decimal('montant_ttc', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_client_produits');
    }
};
