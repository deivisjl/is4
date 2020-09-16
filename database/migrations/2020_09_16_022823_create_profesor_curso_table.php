<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesorCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesor_curso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('pensum_id')->unsigned();
            $table->bigInteger('aula_id')->unsigned();
            $table->bigInteger('ciclo_escolar_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('pensum_id')->references('id')->on('pensum');
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
        Schema::dropIfExists('profesor_curso');
    }
}
