<?php

namespace App\Observers\Inputs\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Settings\Seal;
use Illuminate\Http\Request;

class SealObserver {
    protected $request;
    protected $table = 'seals';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Settings\Seal $seal
     *
     * @return void
     */
    public function created( Seal $seal ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $seal->id,
	    ]);
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Settings\Seal $seal
	 *
	 * @return void
	 */
	public function deleting( Seal $seal ) {

	}
}