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
        Schema::create('tbl_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45)->nullable();
            $table->string('apellidos', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('contrasena', 45)->nullable();
            $table->unsignedBigInteger('id_rol')->nullable();
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->timestamps();
            $table->foreign('id_rol')->references('id')->on('tbl_roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_empresa')->references('id')->on('tbl_empresas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_usuarios');
    }
};