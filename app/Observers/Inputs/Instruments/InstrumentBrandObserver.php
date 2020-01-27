<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Instruments\InstrumentBrand;
use Illuminate\Http\Request;

class InstrumentBrandObserver {
    protected $request;
    protected $table = 'instrument_brands';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Instruments\InstrumentBrand $instrument_brand
     *
     * @return void
     */
    public function created( InstrumentBrand $instrument_brand ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $instrument_brand->id,
	    ]);
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Instruments\InstrumentBrand $instrument_brand
	 *
	 * @return void
	 */
	public function deleting( InstrumentBrand $instrument_brand ) {
		$instrument_brand->instrument_models->each(function ($p){
			$p->delete();
		});
	}
}