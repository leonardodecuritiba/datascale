<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Instruments\InstrumentModel;
use Illuminate\Http\Request;

class InstrumentModelObserver {
    protected $request;
    protected $table = 'instrument_models';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Instruments\InstrumentModel $instrument_model
     *
     * @return void
     */
    public function created( InstrumentModel $instrument_model ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $instrument_model->id,
	    ]);
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Instruments\InstrumentModel $instrument_model
	 *
	 * @return void
	 */
	public function deleting( InstrumentModel $instrument_model ) {
		$instrument_model->pams->each(function ($p){
			$p->delete();
		});
	}
}