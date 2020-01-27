<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCepCitiesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'cep_cities', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->unsignedInteger( 'state_id' );
			$table->foreign( 'state_id' )->references( 'id' )->on( 'cep_states' )->onDelete( 'cascade' );
			$table->string( 'name', 70 );
			$table->timestamps();
			$table->softDeletes();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'cep_cities' );
	}
}
