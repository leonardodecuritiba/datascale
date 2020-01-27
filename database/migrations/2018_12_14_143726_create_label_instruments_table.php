<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_instruments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idselo_instrumento')->nullable();

            $table->unsignedInteger('instrument_id');
            $table->foreign('instrument_id')->references('id')->on('instruments')->onDelete('cascade');

            $table->unsignedInteger('apparatu_set_id');
            $table->foreign('apparatu_set_id')->references('id')->on('apparatus')->onDelete('cascade');

            $table->unsignedInteger('apparatu_unset_id')->nullable();
            $table->foreign('apparatu_unset_id')->references('id')->on('apparatus')->onDelete('cascade');

            $table->unsignedInteger('label_id');
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');
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
        Schema::dropIfExists('label_instruments');
    }
}
