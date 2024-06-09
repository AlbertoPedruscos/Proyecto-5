<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa'); // Agregar columna para la clave externa
            $table->foreign('empresa')->references('id')->on('tbl_empresas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nombre_sitio');
            $table->string('calle');
            $table->string('ciudad');
            $table->decimal('latitud', 10, 6)->nullable();
            $table->decimal('longitud', 10, 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_ubicaciones');
    }
};
