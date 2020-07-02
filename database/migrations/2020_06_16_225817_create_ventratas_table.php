<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentratasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventratas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idpaciente')->unsigned();

            $table->foreign('idpaciente')->references('id')->on('pacientes');
            $table->bigInteger('idservicio');
            $table->datetime('fecha');
            $table->decimal('valor',8,2);
            $table->boolean('condicion');
            $table->boolean('estado');
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
        Schema::dropIfExists('ventratas');
    }
}
