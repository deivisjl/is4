<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreraGradoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrera_grado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('carrera_id')->unsigned();
            $table->bigInteger('grado_id')->unsigned();
            $table->foreign('carrera_id')->references('id')->on('carrera');
            $table->foreign('grado_id')->references('id')->on('grado');
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
        Schema::dropIfExists('carrera_grado');
    }
}
