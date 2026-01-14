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
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('sigle', 255);
            $table->string('intitule', 255);
            $table->foreignId('priorite_id')->nullable();
            $table->foreignId('institution_tutelle_id')->nullable();
            $table->string('direction_agence', 255)->nullable();
            $table->string('contact', 255)->nullable();
            $table->double('cout')->nullable();
            $table->integer('annee_demarrage')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('duree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
