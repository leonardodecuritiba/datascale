<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

            $table->unsignedInteger('picture_id')->nullable();
            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('SET NULL');

            $table->string('description',100);
            $table->string('model',100);
            $table->string( 'serial_number', 50 );
            $table->boolean( 'active' )->default( 1 );
            $table->timestamps();
            $table->softDeletes();


	        $table->unsignedInteger('idequipamento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
    }
}
