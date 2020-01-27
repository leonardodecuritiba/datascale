<?php

namespace App\Observers\HumanResources\Settings;

use App\Models\Commons\Security;
use App\Models\HumanResources\Settings\Region;
use Illuminate\Http\Request;

class RegionObserver {
	protected $request;
	protected $table = 'regions';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\HumanResources\Settings\Region $region
	 *
	 * @return void
	 */
	public function created( Region $region ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate([
			'table' => $this->table,
			'pk'    => $region->id,
		]);
	}
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\HumanResources\Settings\Region $region
	 *
	 * @return void
	 */
	public function deleting( Region $region ) {
		$region->clients->each(function ($p){
            $p->delete();
        });
	}
}