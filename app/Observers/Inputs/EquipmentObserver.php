<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Equipment;
use Illuminate\Http\Request;

class EquipmentObserver {
    protected $request;
    protected $table = 'equipment';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Equipment $equipment
     *
     * @return void
     */
    public function created( Equipment $equipment ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $equipment->id,
	    ]);
    }
	/**
	 * Listen to the Equipment updating event.
	 *
	 * @param  \App\Models\Inputs\Equipment $equipment
	 *
	 * @return void
	 */
	public function saving( Equipment $equipment ) {
		// //testar
		if($this->request->has('picture') && $this->request->get('picture') != NULL){
			$equipment->attachPicture([
				'src'       => $this->request->file('picture'),
				'title'     => NULL
			]);
		}
	}
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Equipment $equipment
	 *
	 * @return void
	 */
	public function deleting( Equipment $equipment ) {
		if($equipment->picture_id != NULL) $equipment->dettachPicture();
	}
}