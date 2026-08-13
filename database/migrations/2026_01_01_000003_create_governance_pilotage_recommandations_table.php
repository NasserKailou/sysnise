<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('governance_pilotage_recommandations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('governance_pilotage_session_id')
                ->constrained('governance_pilotage_sessions')
                ->cascadeOnDelete();
            $table->text('libelle');
            $table->boolean('est_realisee')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governance_pilotage_recommandations');
    }
};
