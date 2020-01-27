<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');

	        $table->unsignedInteger('address_id');
	        $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');

	        $table->unsignedInteger('contact_id');
	        $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

	        $table->unsignedInteger('segment_id')->nullable();
	        $table->foreign('segment_id')->references('id')->on('segments')->onDelete('cascade');

	        $table->unsignedInteger('legal_person_id')->nullable();
	        $table->foreign('legal_person_id')->references('id')->on('legal_people')->onDelete('cascade');

	        $table->unsignedInteger('picture_id')->nullable();
	        $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('SET NULL');

	        $table->string('budget_email',60)->nullable();
	        $table->string('group',100)->nullable();
	        $table->string('responsible_name',100)->nullable();
	        $table->string('cpf',16)->nullable();
            $table->boolean( 'active' )->default( 1 );

	        $table->timestamps();
	        $table->softDeletes();


	        $table->unsignedInteger('idfornecedor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
