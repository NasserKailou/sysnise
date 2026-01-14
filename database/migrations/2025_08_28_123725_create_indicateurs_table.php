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
        Schema::create('indicateurs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable();
            $table->string('intitule', 255);
            $table->string('definition', 255)->nullable();
            $table->string('donnees_requises', 255)->nullable();
            $table->string('methode_calcul', 255)->nullable();
            $table->string('methode_collecte', 255)->nullable();
            $table->string('source', 255)->nullable();
            $table->string('commentaire_limite', 255)->nullable();
            $table->string('niveau_desagregation', 255)->nullable();
            $table->string('periodicite', 255)->nullable();
            $table->string('unite', 255)->nullable();
            $table->string('echelle', 255)->nullable();
            $table->string('lien_avec_cadre_developpement', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicateurs');
    }
};
