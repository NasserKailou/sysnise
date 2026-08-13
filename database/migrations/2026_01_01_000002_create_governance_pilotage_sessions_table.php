<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('governance_pilotage_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('governance_pilotage_id')
                ->constrained('governance_pilotages')
                ->cascadeOnDelete();
            $table->date('date_session');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governance_pilotage_sessions');
    }
};
