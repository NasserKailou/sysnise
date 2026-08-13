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
        /* Schema::table('donnee_indicateurs', function (Blueprint $table) {
           $table->enum('statut', ['en_attente', 'valide', 'rejete'])
                  ->default('en_attente')
                  ->after('valeur')
                  ->comment('Statut de validation: en_attente (par défaut), valide, rejete');
        });*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       /* Schema::table('donnee_indicateurs', function (Blueprint $table) {
            $table->dropColumn('statut');
        });*/
    }
};
