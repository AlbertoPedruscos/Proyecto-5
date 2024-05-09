<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('tbl_reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_trabajador')->nullable();
            $table->unsignedBigInteger('id_plaza')->nullable();
            $table->string('nom_cliente', 45)->nullable();
            $table->string('matricula', 10)->nullable();
            $table->string('marca', 15)->nullable();
            $table->string('modelo', 20)->nullable();
            $table->string('color', 15)->nullable();
            $table->string('num_telf', 9)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('ubicacion_entrada', 20)->nullable();
            $table->string('ubicacion_salida', 20)->nullable();
            $table->dateTime('fecha_entrada')->nullable();
            $table->dateTime('fecha_salida')->nullable();
            $table->string('firma_entrada', 75)->nullable();
            $table->string('firma_salida', 75)->nullable();
            $table->timestamps();
            $table->foreign('id_trabajador')->references('id')->on('tbl_usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_plaza')->references('id')->on('tbl_plazas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('tbl_reservas');
    }
};
