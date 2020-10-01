<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pensum_id')->unsigned();
            $table->bigInteger('inscrito_id')->unsigned();
            $table->bigInteger('bimestre_id')->unsigned();
            $table->integer('nota')->default(0);
            $table->bigInteger('ciclo_escolar_id')->unsigned();
            $table->foreign('pensum_id')->references('id')->on('pensum');
            $table->foreign('inscrito_id')->references('id')->on('inscrito');
            $table->foreign('bimestre_id')->references('id')->on('bimestre');
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
        Schema::dropIfExists('nota');
    }
}
