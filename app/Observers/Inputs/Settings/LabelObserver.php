<?php

namespace App\Observers\Inputs\Settings;

use App\Models\Commons\Security;
use App\Models\Inputs\Settings\Label;
use Illuminate\Http\Request;

class LabelObserver {
    protected $request;
    protected $table = 'labels';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Inputs\Settings\Label $label
     *
     * @return void
     */
    public function created( Label $label ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $label->id,
	    ]);
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Inputs\Settings\Label $label
	 *
	 * @return void
	 */
	public function deleting( Label $label ) {

	}
}