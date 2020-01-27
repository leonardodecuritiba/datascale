<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Instruments\Instrument;
use Illuminate\Http\Request;

class InstrumentObserver {
    protected $request;
    protected $table = 'instruments';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Instruments\Instrument $instrument
     *
     * @return void
     */
    public function created( Instrument $instrument ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $instrument->id,
	    ]);
    }

	/**
	 * Listen to the Equipment updating event.
	 *
	 * @param  \App\Models\Inputs\Instruments\Instrument $instrument
	 *
	 * @return void
	 */
	public function saving( Instrument $instrument ) {
		// //testar
//		if($this->request->has('picture') && $this->request->get('picture') != NULL){
//			$instrument->attachPicture([
//				'src'       => $this->request->file('picture'),
//				'title'     => NULL
//			]);
//		}
	}
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Instruments\Instrument $instrument
	 *
	 * @return void
	 */
	public function deleting( Instrument $instrument ) {
		if($instrument->label_identification()->exists()) $instrument->label_identification->delete();
		if($instrument->label_inventory()->exists()) $instrument->label_inventory->delete();
	}
}