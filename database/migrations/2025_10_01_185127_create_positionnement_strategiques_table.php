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
        Schema::create('positionnement_strategiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id');
            $table->foreignId('action_majeur_strategie_nationale')->nullable();
            $table->foreignId('action_majeur_strategie_sectorielle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positionnement_strategiques');
    }
};
