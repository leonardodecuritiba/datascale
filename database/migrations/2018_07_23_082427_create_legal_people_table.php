<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_people', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('cnpj',60);
	        $table->string('ie',60)->nullable();
	        $table->boolean('exemption_ie')->default(0);
	        $table->string('social_reason',100);
	        $table->string('fantasy_name',100);

	        $table->string('ativ_economica', 100)->nullable();
	        $table->string('sit_cad_vigente', 50)->nullable();
	        $table->string('sit_cad_status', 50)->nullable();
	        $table->date('data_sit_cad')->nullable();
	        $table->string('reg_apuracao', 100)->nullable();
	        $table->date('data_credenciamento')->nullable();
	        $table->string('ind_obrigatoriedade', 100)->nullable();
	        $table->date('data_ini_obrigatoriedade')->nullable();
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
        Schema::dropIfExists('legal_people');
    }
}
