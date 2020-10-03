<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inscrito_id')->unsigned();
            $table->bigInteger('mes_id')->unsigned();
            $table->bigInteger('ciclo_escolar_id')->unsigned();
            $table->decimal('monto');
            $table->foreign('inscrito_id')->references('id')->on('inscrito');
            $table->foreign('mes_id')->references('id')->on('mes');
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
        Schema::dropIfExists('pago');
    }
}
