<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatternVoidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pattern_voids', function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->unsignedBigInteger( 'pattern_id' ); //pattern_id
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('cascade');

	        $table->unsignedBigInteger( 'void_id' ); //void_id
            $table->foreign('void_id')->references('id')->on('voids')->onDelete('cascade');

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
        Schema::dropIfExists('pattern_voids');
    }
}
