<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idlacre')->nullable();

            $table->unsignedInteger('owner_id'); //idtecnico
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('number',20)->unique()->nullable();//numeracao
            $table->string('external_number',20)->nullable();//numeracao
            $table->boolean('extern')->default(0);//externo
            $table->boolean('used')->default(0);

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
        Schema::dropIfExists('seals');
    }
}
