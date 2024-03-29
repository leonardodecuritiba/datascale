<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patterns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('owner_id'); //idtecnico
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('model_id'); //idtecnico
            $table->unsignedInteger('brand_id'); //idtecnico
            $table->unsignedInteger('feature_id'); //idtecnico
            $table->decimal('mass',11,2)->default(0);

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
        Schema::dropIfExists('patterns');
    }
}
