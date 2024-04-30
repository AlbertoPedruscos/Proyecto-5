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
        Schema::create('tbl_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emisor');
            $table->unsignedBigInteger('receptor');
            $table->text('mensaje')->nullable();
            $table->timestamps();

            // Establecer las claves foráneas
            $table->foreign('emisor')->references('id')->on('tbl_usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('receptor')->references('id')->on('tbl_usuarios')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CreateMensajeTable');
    }
};
