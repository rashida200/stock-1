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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type', ['personne', 'entreprise']);
            $table->string('cin')->nullable();
            $table->string('lice')->nullable();
            $table->string('telephone');
            $table->string('adresse');
            $table->string('adresse_projet')->nullable();
            $table->integer('nombre_hectare')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
