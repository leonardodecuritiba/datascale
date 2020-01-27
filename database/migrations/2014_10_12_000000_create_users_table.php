<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

	        $table->unsignedInteger('iduser')->nullable();
	        $table->unsignedInteger('idcolaborador')->nullable();
            $table->unsignedInteger('idtecnico')->nullable();

	        $table->unsignedInteger('company_id')->nullable();
	        $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->unsignedInteger('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->unsignedInteger('contact_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

            $table->string('email',60)->unique();
            $table->string('password');
            $table->string('name',100);
            $table->string('cpf',16)->nullable();
            $table->string('rg',10)->nullable();

            $table->unsignedInteger('cnh_id')->nullable();
            $table->foreign('cnh_id')->references('id')->on('pictures')->onDelete('cascade');

            $table->unsignedInteger('work_permit_id')->nullable();
            $table->foreign('work_permit_id')->references('id')->on('pictures')->onDelete('cascade');

            $table->unsignedInteger('inmetro_id')->nullable();
            $table->foreign('inmetro_id')->references('id')->on('pictures')->onDelete('cascade');

            $table->unsignedInteger('ipem_id')->nullable();
            $table->foreign('ipem_id')->references('id')->on('pictures')->onDelete('cascade');

            $table->unsignedInteger('photo_id')->nullable();
            $table->foreign('photo_id')->references('id')->on('pictures')->onDelete('cascade');

            $table->decimal('discount_max', 5, 2)->default(0);
            $table->decimal('increase_max', 5, 2)->default(0);

            $table->rememberToken();
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
        Schema::drop('users');
    }
}
