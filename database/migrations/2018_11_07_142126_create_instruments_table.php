<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idinstrumento')->nullable();

            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedInteger('pam_id')->nullable();
            $table->foreign('pam_id')->references('id')->on('pams')->onDelete('cascade');

            $table->unsignedInteger('instrument_setor_id')->nullable();
            $table->foreign('instrument_setor_id')->references('id')->on('instrument_setors')->onDelete('cascade');

            $table->unsignedInteger('label_identification_id')->nullable();
            $table->foreign('label_identification_id')->references('id')->on('pictures')->onDelete('SET NULL');

            $table->unsignedInteger('label_inventory_id')->nullable();
            $table->foreign('label_inventory_id')->references('id')->on('pictures')->onDelete('SET NULL');

            $table->string('serial_number',50);
            $table->string('inventory',100)->nullable();
            $table->string('patrimony',100)->nullable();
	        $table->string('year', 4);
            $table->string('ip', 100)->nullable();
            $table->string('address', 50)->nullable();
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
        Schema::dropIfExists('instruments');
    }
}
