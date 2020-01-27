<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApparatuServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparatu_services', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('idservico_prestado')->nullable();

	        $table->unsignedInteger('apparatu_id');
	        $table->foreign('apparatu_id')->references('id')->on('apparatus')->onDelete('cascade');

	        $table->integer('service_id')->unsigned();
	        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

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
        Schema::dropIfExists('apparatu_services');
    }
}
