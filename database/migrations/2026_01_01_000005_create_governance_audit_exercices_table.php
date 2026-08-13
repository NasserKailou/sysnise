<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('governance_audit_exercices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('governance_audit_id')
                ->constrained('governance_audits')
                ->cascadeOnDelete();
            // Ex: "2023", "2024", "2023-2024"
            $table->string('exercice_comptable');
            // Les comptes sont-ils certifiés sans réserve ? (Oui/Non)
            $table->boolean('comptes_certifies_sans_reserves')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governance_audit_exercices');
    }
};
