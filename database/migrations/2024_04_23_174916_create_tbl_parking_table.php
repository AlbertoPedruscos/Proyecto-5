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
        Schema::create('tbl_parking', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45)->nullable();
            $table->longText('latitud')->nullable();
            $table->longText('longitud')->nullable();
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->unsignedBigInteger('id_plaza')->nullable();
            $table->timestamps();

            $table->index('id_empresa');

            $table->foreign('id_empresa')->references('id')->on('tbl_empresas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_parking');
    }
};