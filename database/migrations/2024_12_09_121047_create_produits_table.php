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
        Schema::create('produits', function (Blueprint $table) {
            $table->id(); 
            $table->string('reference', 50)->unique();
            $table->string('designation', 255);
            $table->integer('quantity')->default(0);
            $table->decimal('prix_achat_ht', 10, 2);
            $table->decimal('tva', 5, 2);
            $table->decimal('prix_achat_ttc', 10, 2)->storedAs('prix_achat_ht + (prix_achat_ht * tva / 100)');
            $table->decimal('prix_vente', 10, 2);
            $table->decimal('total_ht', 15, 2)->storedAs('quantity * prix_achat_ht');
            $table->decimal('total_ttc', 15, 2)->storedAs('quantity * prix_achat_ttc');
            $table->foreignId('fournisseur_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
