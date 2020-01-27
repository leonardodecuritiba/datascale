<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstrumentModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrument_models', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idinstrumento_modelo')->nullable();
            $table->unsignedInteger('instrument_brand_id');
            $table->foreign('instrument_brand_id')->references('id')->on('instrument_brands')->onDelete('cascade');
            $table->string('description',100)->unique();
            $table->boolean( 'active' )->default( 1 );
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
        Schema::dropIfExists('instrument_models');
    }
}
