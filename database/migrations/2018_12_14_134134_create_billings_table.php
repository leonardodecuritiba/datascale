<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idfaturamentos')->nullable();

            $table->unsignedInteger('client_id'); //idcliente
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedInteger('status'); //idstatus_faturamento

            $table->unsignedInteger('payment_id'); //idpagamento
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');

            $table->integer('nfe_id_homologacao')->unsigned()->nullable(); //idnfe_homologacao
            $table->dateTime('nfe_date_homologacao')->nullable(); //data_nfe_homologacao

            $table->integer('nfe_id_producao')->unsigned()->nullable(); //idnfe_producao
            $table->dateTime('nfe_date_producao')->nullable(); //data_nfe_producao

            $table->integer('nfse_id_homologacao')->unsigned()->nullable(); //idnfse_homologacao
            $table->dateTime('nfse_date_homologacao')->nullable(); //data_nfse_homologacao

            $table->integer('nfse_id_producao')->unsigned()->nullable(); //idnfse_producao
            $table->dateTime('nfse_date_producao')->nullable(); //data_nfse_producao

            $table->string('nfe_link', 200)->nullable(); //link_nfe
            $table->string('nfse_link', 200)->nullable(); //link_nfse

            $table->boolean('cost_center')->default(0); //centro_custo

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
        Schema::dropIfExists('billings');
    }
}
