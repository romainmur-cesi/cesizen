<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type', 25);
            $table->string('message', 255);
            $table->date('date');
            $table->timestamps();
            $table->foreignId('id_utilisateur')->constrained('utilisateurs')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};