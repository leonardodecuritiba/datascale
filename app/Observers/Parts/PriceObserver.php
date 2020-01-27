<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Parts\Price;
use Illuminate\Http\Request;

class PriceObserver {
    protected $request;
    protected $table = 'prices';

    public function __construct( Request $request ) {
        $this->request = $request;
    }
    /**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Parts\Price $price
     *
     * @return void
     */
    public function created( Price $price ) {
        //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $price->id,
	    ]);

    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Parts\Price $price
	 *
	 * @return void
	 */
	public function deleting( Price $price ) {
		$price->part_prices->each(function ($p){
			$p->delete();
		});
		$price->service_prices->each(function ($p){
			$p->delete();
		});
	}
}