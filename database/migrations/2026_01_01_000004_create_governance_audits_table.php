<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('governance_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained()->cascadeOnDelete();
            // Les comptes du projet ont-ils fait l'objet régulièrement d'audit ? (Oui/Non)
            $table->boolean('comptes_audites')->nullable();
            // Nombre d'audits réalisés du démarrage à la date de la revue
            $table->unsignedInteger('nombre_audits_realises')->nullable();
            // Commentaire libre, ex: "premier audit attendu en mai 2026 avec rapport le 30/06/2026"
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->unique('projet_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governance_audits');
    }
};
