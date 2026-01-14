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
        Schema::create('orientation_cadre_developpements', function (Blueprint $table) {
            $table->id();
            $table->string('intitule', 255);
            $table->foreignId('cadre_developpement_id');
            $table->foreignId('cadre_logique_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientation_cadre_developpements');
    }
};
