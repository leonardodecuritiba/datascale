<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecuritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('securities', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('creator_id')->nullable();
	        $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
	        $table->unsignedInteger('validator_id')->nullable();
	        $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');

	        $table->string( 'verb', 6 )->nullable();
	        $table->string( 'table', 30 )->nullable();
	        $table->string( 'pk', 20 )->nullable();
	        $table->timestamp('validated_at')->nullable();
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
        Schema::dropIfExists('securities');
    }
}
