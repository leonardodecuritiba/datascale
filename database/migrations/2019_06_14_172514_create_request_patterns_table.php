<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPatternsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'request_patterns', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );

			$table->unsignedInteger( 'requester_id' ); //idrequester
			$table->foreign( 'requester_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
			$table->unsignedInteger( 'manager_id' )->nullable(); //idmanager
			$table->foreign( 'manager_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );

			$table->string( 'number', 50 )->nullable(); //numero de compra
			$table->unsignedTinyInteger( 'status' );
			$table->unsignedTinyInteger( 'type' );
			$table->decimal( 'value', 11, 2 )->default( 0 );
			$table->string( 'reason', 1000 );
			$table->mediumText( 'response' )->nullable();
			$table->dateTime( 'denied_at' )->nullable();
			$table->dateTime( 'accepted_at' )->nullable();
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
		Schema::dropIfExists( 'request_patterns' );
	}
}
