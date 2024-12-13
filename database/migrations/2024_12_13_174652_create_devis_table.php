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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Foreign key for client
            $table->date('date_devis');
            $table->decimal('total_ht', 10, 2)->default(0); // Total HT
            $table->decimal('total_ttc', 10, 2)->default(0); // Total TTC
            $table->string('statut')->default('pending'); // Status of the devis (e.g., pending, accepted)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
