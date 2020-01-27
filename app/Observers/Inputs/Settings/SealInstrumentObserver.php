<?php

namespace App\Observers\Inputs\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Settings\SealInstrument;
use Illuminate\Http\Request;

class SealInstrumentObserver {
    protected $request;
    protected $table = 'seal_instruments';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Settings\SealInstrument $seal_instrument
     *
     * @return void
     */
    public function created( SealInstrument $seal_instrument ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $seal_instrument->id,
	    ]);
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Settings\SealInstrument $seal_instrument
	 *
	 * @return void
	 */
	public function deleting( SealInstrument $seal_instrument ) {

	}
}