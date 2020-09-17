<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscritoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscrito', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('alumno_id')->unsigned();
            $table->bigInteger('aula_id')->unsigned();
            $table->bigInteger('ciclo_escolar_id')->unsigned();
            $table->integer('promovido')->default(0);
            $table->integer('repitente')->default(0);
            $table->foreign('alumno_id')->references('id')->on('alumno');
            $table->foreign('aula_id')->references('id')->on('aula');
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
        Schema::dropIfExists('inscrito');
    }
}
