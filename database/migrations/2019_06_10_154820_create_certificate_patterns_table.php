<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatePatternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_patterns', function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->unsignedBigInteger( 'certificate_id' ); //certificate_id
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');

	        $table->unsignedBigInteger( 'pattern_id' ); //pattern_id
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('cascade');

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
        Schema::dropIfExists('certificate_patterns');
    }
}
