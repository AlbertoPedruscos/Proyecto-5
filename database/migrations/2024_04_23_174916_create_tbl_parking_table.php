<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_parkings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 45)->nullable();
            $table->longText('latitud')->nullable();
            $table->longText('longitud')->nullable();
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->timestamps();

            $table->foreign('id_empresa')->references('id')->on('tbl_empresas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_parkings');
    }
};