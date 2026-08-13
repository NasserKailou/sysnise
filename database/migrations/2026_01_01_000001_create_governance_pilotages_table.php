<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('governance_pilotages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained()->cascadeOnDelete();
            // Le projet dispose-t-il d'un organe d'orientation/pilotage ? (Oui/Non)
            $table->boolean('dispose_organe_pilotage')->nullable();
            $table->unsignedInteger('nombre_sessions_prevues')->nullable();
            $table->unsignedInteger('nombre_sessions_tenues')->nullable();
            $table->timestamps();

            $table->unique('projet_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governance_pilotages');
    }
};
