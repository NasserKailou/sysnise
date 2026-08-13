<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('governance_audit_recommandations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('governance_audit_exercice_id')
                ->constrained('governance_audit_exercices')
                ->cascadeOnDelete();
            $table->text('libelle');
            $table->boolean('est_realisee')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governance_audit_recommandations');
    }
};
