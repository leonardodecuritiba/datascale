<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApparatuPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparatu_parts', function (Blueprint $table) {
	        $table->increments('id');

	        $table->unsignedInteger('idpeca_utilizada')->nullable();

	        $table->unsignedInteger('apparatu_id');
	        $table->foreign('apparatu_id')->references('id')->on('apparatus')->onDelete('cascade');

	        $table->integer('part_id')->unsigned();
	        $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');

	        $table->decimal('value',11,2);
	        $table->smallInteger('quantity');
	        $table->decimal('discount', 11, 2)->default(0);
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
        Schema::dropIfExists('apparatu_parts');
    }
}
