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
        Schema::create('bons_livraison', function (Blueprint $table) {
            $table->id();
            $table->string('numero_bl')->unique();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->date('date_vente');
            $table->decimal('total_ht', 15, 2);
            $table->decimal('total_ttc', 15, 2);
            $table->enum('statut', ['en_attente', 'livré', 'annulé'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bons_livraison');
    }
};
