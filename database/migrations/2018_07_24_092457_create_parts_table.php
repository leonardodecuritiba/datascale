<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->increments('id');

	        $table->unsignedInteger('provider_id');
	        $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');

	        $table->unsignedInteger('brand_id')->nullable();
	        $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

	        $table->unsignedInteger('group_id')->nullable();
	        $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

	        $table->unsignedInteger('picture_id')->nullable();
	        $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('SET NULL');

	        $table->unsignedTinyInteger('unity_id');

	        $table->enum('type', array('part', 'product'));


	        $table->string('auxiliar_code',50)->nullable();
	        $table->string('bar_code',50)->nullable();
	        $table->string('description',100);
	        $table->string('technical_description',100);

	        $table->string('sub_group',50)->nullable();
	        $table->tinyInteger('warranty')->nullable();


	        //taxation

	        $table->unsignedInteger('ncm_id');
	        $table->foreign('ncm_id')->references('id')->on('ncms')->onDelete('cascade');

	        $table->unsignedTinyInteger('cfop_id');
	        $table->unsignedTinyInteger('cst_id');
	        $table->unsignedTinyInteger('nature_operation_id');

	        $table->string('cest',10);
	        $table->decimal('icms_base_calculo', 5, 2)->default(0);
	        $table->decimal('icms_valor_total', 5, 2)->default(0);
	        $table->decimal('icms_base_calculo_st', 5, 2)->default(0);
	        $table->decimal('icms_valor_total_st', 5, 2)->default(0);

	        $table->string('icms_origem', 1)->default(0);
	        $table->string('icms_situacao_tributaria', 3)->default('500');
	        $table->string('pis_situacao_tributaria', 2)->default('07');
	        $table->string('cofins_situacao_tributaria', 2)->default('07');

	        $table->decimal('valor_unitario_comercial', 20, 2)->default(0);
	        $table->decimal('unidade_tributavel', 6, 2)->default(0);
	        $table->decimal('valor_unitario_tributavel', 5, 2)->default(0);

	        $table->decimal('valor_ipi', 5, 2)->default(0);

            $table->decimal('technical_commission',5,2)->default(0);
            $table->decimal('seller_commission',5,2)->default(0);
	        $table->decimal('valor_frete', 11, 2)->default(0);
	        $table->decimal('valor_seguro', 11, 2)->default(0);
	        $table->decimal('valor_total', 11, 2);
	        $table->boolean( 'active' )->default( 1 );

	        $table->timestamps();
	        $table->softDeletes();


	        $table->unsignedInteger('idpeca');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parts');
    }
}
