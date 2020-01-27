<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPatternItensTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'request_pattern_itens', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );

			$table->unsignedBigInteger( 'request_pattern_id' ); //request_pattern_id
			$table->foreign( 'request_pattern_id' )->references( 'id' )->on( 'request_patterns' )->onDelete( 'cascade' );

			$table->unsignedBigInteger( 'pattern_id' ); //pattern_id
			$table->foreign( 'pattern_id' )->references( 'id' )->on( 'patterns' )->onDelete( 'cascade' );

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
		Schema::dropIfExists( 'request_pattern_itens' );
	}
}
