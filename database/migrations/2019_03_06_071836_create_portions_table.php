<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portions', function (Blueprint $table) {
            $table->increments('id');

	        $table->unsignedInteger('payment_id');
	        $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');

	        $table->unsignedTinyInteger('payment_form')->nullable();

	        $table->date('due_at');
	        $table->date('paid_at')->nullable();
	        $table->date('setted_at')->nullable();
	        $table->tinyInteger('portion_number');
	        $table->decimal('portion_value', 11, 2);
	        $table->boolean('status')->default(0);

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
        Schema::dropIfExists('portions');
    }
}
