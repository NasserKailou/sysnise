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
        Schema::create('recherche_financements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id');
            $table->foreignId('source_financement_id');
            $table->foreignId('niveau_financement_id');
            $table->foreignId('mode_financement_id');
            $table->string('bailleurs', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recherche_financements');
    }
};
