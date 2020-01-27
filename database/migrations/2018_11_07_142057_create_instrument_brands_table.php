<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstrumentBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrument_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idinstrumento_marca')->nullable();
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
        Schema::dropIfExists('instrument_brands');
    }
}
