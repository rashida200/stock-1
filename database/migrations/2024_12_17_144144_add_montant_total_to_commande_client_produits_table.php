<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('commande_client_produits', function (Blueprint $table) {
        $table->decimal('montant_total', 10, 2)->after('montant_ttc')->nullable();
    });
}

public function down()
{
    Schema::table('commande_client_produits', function (Blueprint $table) {
        $table->dropColumn('montant_total');
    });
}
};
