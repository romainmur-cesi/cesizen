<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('consulter', function (Blueprint $table) {
            $table->id(); // clé primaire
            $table->foreignId('id_contenu')->constrained('contenus')->onDelete('cascade');
            $table->foreignId('id_utilisateur')->constrained('utilisateurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('consulter');
    }
};