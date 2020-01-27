<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSealInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seal_instruments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idlacre_instrumento')->nullable();

            $table->unsignedInteger('instrument_id');
            $table->foreign('instrument_id')->references('id')->on('instruments')->onDelete('cascade');

            $table->unsignedInteger('apparatu_set_id');
            $table->foreign('apparatu_set_id')->references('id')->on('apparatus')->onDelete('cascade');

            $table->unsignedInteger('apparatu_unset_id')->nullable();
            $table->foreign('apparatu_unset_id')->references('id')->on('apparatus')->onDelete('cascade');

            $table->unsignedInteger('seal_id');
            $table->foreign('seal_id')->references('id')->on('seals')->onDelete('cascade');
            $table->boolean( 'external' )->default(0);

            $table->dateTime('set_at')->nullable(); //afixado_em
            $table->dateTime('unset_at')->nullable(); //retirado_em

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
        Schema::dropIfExists('seal_instruments');
    }
}
