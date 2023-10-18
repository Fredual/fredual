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
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cita_id');
            $table->date('fecha_turno');
            $table->time('hora_inicio');
            $table->time('hora_fin'); 
            $table->string('statusT');
            $table->timestamps();
            $table->foreign('cita_id')->references('id')->on('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
