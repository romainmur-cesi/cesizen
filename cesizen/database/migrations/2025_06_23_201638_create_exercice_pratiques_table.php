<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exercice_pratiques', function (Blueprint $table) {
            $table->id();
            $table->date('date_pratique');
            $table->float('temps_pratique');
            $table->foreignId('id_exercice_respiration')->constrained('exercice_respirations')->onDelete('cascade');
            $table->foreignId('id_utilisateur')->constrained('utilisateurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exercice_pratiques');
    }
};