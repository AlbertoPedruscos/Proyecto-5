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
        Schema::create('tbl_empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 45)->nullable();
            $table->timestamps();
        });

        Schema::table('tbl_usuarios', function (Blueprint $table) {
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
        Schema::table('tbl_usuarios', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
        });

        Schema::dropIfExists('tbl_empresas');
    }
};