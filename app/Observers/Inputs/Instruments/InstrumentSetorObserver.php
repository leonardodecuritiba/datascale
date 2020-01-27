<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Instruments\InstrumentSetor;
use Illuminate\Http\Request;

class InstrumentSetorObserver {
    protected $request;
    protected $table = 'instrument_setors';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Instruments\InstrumentSetor $instrument_setor
     *
     * @return void
     */
    public function created( InstrumentSetor $instrument_setor ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $instrument_setor->id,
	    ]);
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Instruments\InstrumentSetor $instrument_setor
	 *
	 * @return void
	 */
	public function deleting( InstrumentSetor $instrument_setor ) {
		$instrument_setor->instruments->each(function ($p){
			$p->delete();
		});
	}
}