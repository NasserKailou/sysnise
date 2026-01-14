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
        Schema::table('donnee_indicateurs', function (Blueprint $table) {
            $table->text('commentaire_rejet')->nullable()->after('statut')->comment('Commentaire en cas de rejet de la donnée');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donnee_indicateurs', function (Blueprint $table) {
            $table->dropColumn('commentaire_rejet');
        });
    }
};
