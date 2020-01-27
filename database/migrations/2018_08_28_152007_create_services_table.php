<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idservico');

            $table->unsignedInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

            $table->unsignedTinyInteger('unity_id');

            $table->string('name',100)->unique();
            $table->string('description',255);
            $table->decimal('value',11,2)->default(0);
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
        Schema::dropIfExists('services');
    }
}
