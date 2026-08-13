<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('governance_solutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('governance_probleme_id')
                ->constrained('governance_problemes')
                ->cascadeOnDelete();
            $table->text('libelle');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governance_solutions');
    }
};
