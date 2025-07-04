<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exercice_respirations', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 25);
            $table->string('description', 255);
            $table->float('duree');
            $table->float('temps_inspiration');
            $table->float('temps_apnee');
            $table->float('temps_expiration');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exercice_respirations');
    }
};