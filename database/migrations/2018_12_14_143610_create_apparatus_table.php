<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApparatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparatus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idaparelho_manutencao')->nullable();

            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->unsignedInteger('instrument_id')->nullable();
            $table->foreign('instrument_id')->references('id')->on('instruments')->onDelete('SET NULL');

            $table->unsignedInteger('equipment_id')->nullable();
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('SET NULL');

            $table->string('defect',500)->nullable(); //defeito
            $table->string('solution',500)->nullable();//solucao
            $table->string('call_number', 50)->nullable(); //numero_chamado

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apparatus');
    }
}
