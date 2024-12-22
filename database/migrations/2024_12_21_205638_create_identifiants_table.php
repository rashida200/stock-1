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
        Schema::create('identifiants', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 255);
            $table->foreignId('banque_id')->constrained('banques')->onDelete('cascade');
            $table->string('company_description', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->string('ice', 20)->nullable();
            $table->string('rc', 20)->nullable();
            $table->string('if', 20)->nullable();
            $table->string('patente', 20)->nullable();
            $table->string('cnss', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('bank_account', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identifiants');
    }
};
