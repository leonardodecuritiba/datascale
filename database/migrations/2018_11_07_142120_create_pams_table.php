<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idinstrumento_base')->nullable();

            $table->unsignedInteger('instrument_model_id');
            $table->foreign('instrument_model_id')->references('id')->on('instrument_models')->onDelete('cascade');

            $table->unsignedInteger('picture_id')->nullable();
            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('SET NULL');

            $table->string('description', 100);
            $table->string('division', 100);
            $table->string('ordinance', 100);
            $table->string('capacity', 100);
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
        Schema::dropIfExists('pams');
    }
}
