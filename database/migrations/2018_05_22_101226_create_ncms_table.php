<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNcmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ncms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',15)->unique();
            $table->string('description',100)->nullable();
            $table->decimal('ipi',5,2)->default(0);
            $table->decimal('pis',5,2)->default(0);
            $table->decimal('cofins',5,2)->default(0);
            $table->decimal('nacional',5,2)->default(0);
            $table->decimal('importacao',5,2)->default(0);
            $table->boolean( 'active' )->default( 1 );
            $table->timestamps();
            $table->softDeletes();


	        $table->unsignedInteger('idncm')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ncms');
    }
}
