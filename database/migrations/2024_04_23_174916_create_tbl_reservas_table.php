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
        Schema::create('tbl_reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_trabajador')->nullable();
            $table->unsignedBigInteger('id_plaza')->nullable();
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->string('firma', 75)->nullable();
            $table->timestamps();

            $table->index('id_trabajador');
            $table->index('id_plaza');

            $table->foreign('id_trabajador')->references('id')->on('tbl_usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_plaza')->references('id')->on('tbl_plazas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_reservas');
    }
};
