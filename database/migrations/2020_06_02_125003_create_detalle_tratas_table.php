<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleTratasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_tratas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idventrata')->unsigned();
            $table->foreign('idventrata')->references('id')->on('ventratas');
            $table->bigInteger('idtratamiento')->unsigned();
            $table->foreign('idtratamiento')->references('id')->on('tratamientos');
            $table->boolean('condicion');
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
        Schema::dropIfExists('detalle_tratas');
    }
}
