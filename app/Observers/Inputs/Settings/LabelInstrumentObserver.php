<?php

namespace App\Observers\Inputs\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Settings\LabelInstrument;
use Illuminate\Http\Request;

class LabelInstrumentObserver {
    protected $request;
    protected $table = 'label_instruments';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Settings\LabelInstrument $label_instrument
     *
     * @return void
     */
    public function created( LabelInstrument $label_instrument ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $label_instrument->id,
	    ]);
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Settings\LabelInstrument $label_instrument
	 *
	 * @return void
	 */
	public function deleting( LabelInstrument $label_instrument ) {

	}
}