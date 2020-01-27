<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');

	        $table->unsignedInteger('cost_center_id')->nullable();
	        $table->foreign('cost_center_id')->references('id')->on('clients')->onDelete('SET NULL');

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

	        $table->string('responsible_name',100)->nullable();
	        $table->string('cpf',16)->nullable();

	        $table->string('email_budget',60)->nullable();;
	        $table->string('email_bill', 60)->nullable();

	        //payments
	        //technical
	        $table->unsignedInteger('technical_price_id');
	        $table->foreign('technical_price_id')->references('id')->on('prices')->onDelete('cascade');

	        $table->unsignedTinyInteger('technical_form_payment_id');
	        $table->unsignedTinyInteger('technical_billing_issue_type_id')->nullable();
	        $table->string('technical_due_payment', 100)->nullable()->default(NULL);
	        $table->decimal('technical_credit_limit', 11, 2)->default(0);

	        //commercial
	        $table->unsignedInteger('commercial_price_id');
	        $table->foreign('commercial_price_id')->references('id')->on('prices')->onDelete('cascade');

	        $table->unsignedTinyInteger('commercial_form_payment_id');
	        $table->unsignedTinyInteger('commercial_billing_issue_type_id')->nullable();
	        $table->string('commercial_due_payment', 100)->nullable()->default(NULL);
	        $table->decimal('commercial_credit_limit', 11, 2)->default(0);

            $table->boolean('cost_center')->default(0);

            $table->decimal('distance',11,2); //em km
            $table->decimal('tolls', 11, 2)->default(0); //em R$
            $table->decimal('other_costs', 11, 2)->default(0); //em R$
            $table->boolean('called_number')->default(0);
	        $table->boolean( 'active' )->default( 1 );

	        $table->timestamps();
	        $table->softDeletes();

	        /*
            $table->integer('idcolaborador_criador')->unsigned();
            $table->foreign('idcolaborador_criador')->references('idcolaborador')->on('colaboradores')->onDelete('cascade');

            $table->integer('idcolaborador_validador')->unsigned()->nullable();
            $table->foreign('idcolaborador_validador')->references('idcolaborador')->on('colaboradores')->onDelete('cascade');

            $table->timestamp('validated_at')->nullable();
			*/
	        $table->unsignedInteger('idcliente');
	        $table->unsignedInteger('idcliente_centro_custo')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
