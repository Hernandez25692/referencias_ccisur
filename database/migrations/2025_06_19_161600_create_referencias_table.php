<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('referencias', function (Blueprint $table) {
            $table->id();
            $table->string('correlativo')->unique();
            $table->text('asunto')->nullable();
            $table->string('solicitado_por')->nullable();
            $table->string('autorizado_por')->nullable();
            $table->string('documento')->nullable(); // Ruta del archivo
            $table->string('departamento'); // GAF, GOR, etc.
            $table->enum('estado', ['pendiente', 'completo'])->default('pendiente');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referencias');
    }
};
