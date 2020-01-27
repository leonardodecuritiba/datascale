<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedTinyInteger('type');
	        $table->unsignedTinyInteger('status');
	        $table->unsignedInteger('requester_id'); //idrequester
	        $table->foreign('requester_id')->references('id')->on('users')->onDelete('cascade');
	        $table->unsignedInteger('manager_id')->nullable(); //idmanager
	        $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade');

	        $table->string('reason', 1000);
	        $table->mediumText('parameters');
	        $table->mediumText('response')->nullable();
	        $table->dateTime('end_at')->nullable(); //enddate
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
        Schema::dropIfExists('requests');
    }
}
