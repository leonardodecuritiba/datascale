<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voids', function (Blueprint $table) {
            $table->bigIncrements( 'id' );

	        $table->unsignedInteger( 'owner_id' ); //idtecnico
	        $table->foreign( 'owner_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );

            $table->string( 'number', 20 )->unique();
            $table->boolean( 'used' )->default( 0 );
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
        Schema::dropIfExists('voids');
    }
}
