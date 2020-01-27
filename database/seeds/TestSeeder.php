<?php

use Illuminate\Database\Seeder;
use App\Models\Commons\Voidx;
use App\Models\Requests\RequestPattern;
use App\Models\Requests\Settings\RequestPatternItem;

class TestSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//php artisan db:seed --class=TestSeeder
//		$data = null;
//		for ( $i = 1001; $i < 1200; $i ++ ) {
//			$data[] =
//				[
//					'owner_id' => 7, //silva.zanin@gmail.com
//					'number'   => $i
//				];
//		}
//		Voidx::insert( $data );

		RequestPattern::flushEventListeners();
		RequestPattern::getEventDispatcher();

		RequestPatternItem::flushEventListeners();
		RequestPatternItem::getEventDispatcher();

		factory( RequestPattern::class, 1000 )->create();
		$this->command->info( 'Request complete ...' );

		factory( RequestPatternItem::class, 1500 )->create();
		$this->command->info( 'Item complete ...' );

	}
}
