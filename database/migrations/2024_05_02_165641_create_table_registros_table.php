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
        Schema::create('tbl_registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario'); // Cambiamos 'user_id' a 'id_usuario'
            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->foreign('id_usuario')->references('id')->on('tbl_usuarios')->onUpdate('cascade'); // Establecemos la relación con 'tbl_usuarios'
            $table->timestamps();
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_registros');
    }
};
