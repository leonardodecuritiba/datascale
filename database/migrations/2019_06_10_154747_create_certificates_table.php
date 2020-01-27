<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('manager_id')->nullable(); //idmanager
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade');

	        $table->unsignedBigInteger( 'file_id' )->nullable(); //idmanager
	        $table->foreign( 'file_id' )->references( 'id' )->on( 'files' )->onDelete( 'cascade' );

	        $table->string( 'number', 50 );
	        $table->date( 'verified_at' )->nullable();
	        $table->date( 'due_at' )->nullable();
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
        Schema::dropIfExists('certificates');
    }
}
