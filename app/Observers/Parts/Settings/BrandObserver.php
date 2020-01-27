<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Parts\Settings\Brand;
use Illuminate\Http\Request;

class BrandObserver {
	protected $request;
	protected $table = 'brands';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Parts\Settings\Brand $brand
	 *
	 * @return void
	 */
	public function created( Brand $brand ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate([
			'table' => $this->table,
			'pk'    => $brand->id,
		]);
	}

	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Parts\Settings\Brand $brand
	 *
	 * @return void
	 */
	public function deleting( Brand $brand ) {
        $brand->parts->each(function ($p){
            $p->delete();
        });
	}
}