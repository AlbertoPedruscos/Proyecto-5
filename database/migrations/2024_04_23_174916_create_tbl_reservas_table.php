<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_trabajador')->nullable();
            $table->unsignedBigInteger('id_plaza')->nullable();
            $table->unsignedBigInteger('ubicacion_entrada')->nullable(); // Cambiado a ID de ubicación de entrada
            $table->unsignedBigInteger('ubicacion_salida')->nullable(); // Cambiado a ID de ubicación de salida
            $table->string('nom_cliente', 45);
            $table->string('matricula', 10);
            $table->string('marca', 15);
            $table->string('modelo', 15);
            $table->string('color', 15)->nullable();
            $table->string('num_telf', 20);
            $table->string('email', 45);
            $table->dateTime('fecha_entrada');
            $table->dateTime('fecha_salida');
            $table->string('firma_entrada', 75)->nullable();
            $table->string('firma_salida', 75)->nullable();
            $table->string('notas')->nullable(); // Nuevo campo 'notas' agregado como VARCHAR y permitiendo valores nulos
            $table->timestamps();

            $table->foreign('id_trabajador')->references('id')->on('tbl_usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_plaza')->references('id')->on('tbl_plazas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ubicacion_entrada')->references('id')->on('tbl_ubicaciones')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ubicacion_salida')->references('id')->on('tbl_ubicaciones')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_reservas');
    }
}
