<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('email', 50)->unique();
            $table->string('mot_de_passe', 50);
            $table->date('date_de_naissance');
            $table->string('preferences', 25)->nullable();
            $table->string('role', 25)->default('utilisateur');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('utilisateurs');
    }
};