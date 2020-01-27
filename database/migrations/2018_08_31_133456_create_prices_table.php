<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');

	        $table->string('name',100)->unique();
	        $table->string('description',255);
	        $table->boolean( 'active' )->default( 1 );

	        $table->timestamps();
	        $table->softDeletes();


	        $table->unsignedInteger('idtabela_preco')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
