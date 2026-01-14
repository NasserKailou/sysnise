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
        Schema::create('cadre_logiques', function (Blueprint $table) {
            $table->id();
            $table->string('intitule', 255);
            $table->integer('niveau');
            $table->foreignId('cadre_logique_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadre_logiques');
    }
};
