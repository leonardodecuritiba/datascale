<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idordem_servico')->nullable();

            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('status');

            $table->unsignedInteger('cost_center_id')->nullable();
            $table->foreign('cost_center_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedInteger('billing_id')->nullable();
            $table->foreign('billing_id')->references('id')->on('billings')->onDelete('cascade');


            $table->dateTime('finished_at')->nullable(); //data_finalizada
            $table->dateTime('closed_at')->nullable(); //data_fechada
            $table->string('call_number',50)->nullable(); //numero_chamado
            $table->string('responsible', 100)->nullable(); //responsavel
            $table->string('responsible_cpf', 16)->nullable(); //responsavel_cpf
            $table->string('responsible_position', 50)->nullable(); //responsavel_cargo
            $table->decimal('total_value',11,2); //valor_total
            $table->decimal('discount_tec', 5, 2)->default(0); //desconto_tec
            $table->decimal('increase_tec', 5, 2)->default(0); //acrescimo_tec
            $table->decimal('final_value',11,2); //valor_final

            $table->decimal('travel_cost',11,2); //custos_deslocamento
            $table->decimal('tolls',11,2);  //valor_total em R$
            $table->decimal('other_cost',11,2);  //valor_total em R$
            $table->boolean('exemption_cost')->default(0);

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
        Schema::dropIfExists('orders');
    }
}
