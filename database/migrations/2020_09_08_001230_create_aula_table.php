<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aula', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('carrera_grado_id')->unsigned();
            $table->bigInteger('seccion_id')->unsigned();
            $table->bigInteger('ciclo_escolar_id')->unsigned();
            $table->foreign('carrera_grado_id')->references('id')->on('carrera_grado');
            $table->foreign('seccion_id')->references('id')->on('seccion');
            $table->foreign('ciclo_escolar_id')->references('id')->on('ciclo_escolar');
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
        Schema::dropIfExists('aula');
    }
}
