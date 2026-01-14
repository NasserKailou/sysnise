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
        Schema::create('cadre_developpements', function (Blueprint $table) {
            $table->id();
            $table->string('intitule', 255);
            $table->string('structure_responsable', 255)->nullable();
            $table->string('periode_debut', 255)->nullable();
            $table->string('periode_fin', 255)->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('cadre_developpement_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadre_developpements');
    }
};
