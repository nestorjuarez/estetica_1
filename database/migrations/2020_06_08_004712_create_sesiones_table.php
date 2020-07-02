<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSesionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('iddetalle_trata')->unsigned();
            $table->foreign('iddetalle_trata')->references('id')->on('detalle_tratas');
            $table->datetime('fecha');
            $table->decimal('frecuencia',8,2);
            $table->integer('tiempo');
            $table->integer('cantidad');
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
        Schema::dropIfExists('sesiones');
    }
}
