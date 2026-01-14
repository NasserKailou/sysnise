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
        Schema::create('etude_identifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id');
            $table->foreignId('etude_id');
            $table->boolean('etude_disponible');
            $table->string('document_etude', 255)->nullable();
            $table->boolean('etude_envisagee')->nullable();
            $table->foreignId('source_financement_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etude_identifications');
    }
};
