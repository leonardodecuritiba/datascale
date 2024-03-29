<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_prices', function (Blueprint $table) {

	        $table->increments('id');

	        $table->unsignedInteger('price_id');
	        $table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');

	        $table->unsignedInteger('service_id');
	        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

	        $table->decimal('price',11,2)->default(0);
	        $table->decimal('price_min',11,2)->default(0);
	        $table->decimal('range',11,2)->default(0);
	        $table->decimal('range_min',11,2)->default(0);

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
        Schema::dropIfExists('service_prices');
    }
}


