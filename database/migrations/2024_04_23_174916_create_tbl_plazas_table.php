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
        Schema::create('tbl_plazas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45)->nullable();
            $table->decimal('planta')->nullable();
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->unsignedBigInteger('id_parking')->nullable();
            $table->timestamps();

            $table->index('id_estado');
            $table->index('id_parking');

            $table->foreign('id_estado')->references('id')->on('tbl_estados')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_parking')->references('id')->on('tbl_parking')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_plazas');
    }
};