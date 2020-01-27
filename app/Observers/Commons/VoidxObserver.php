<?php

namespace App\Observers\Ipem;

use App\Models\Commons\Security;
use App\Models\Commons\Voidx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoidxObserver {
	protected $request;
	protected $table = 'voids';

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	/**
	 * Listen to the InstrumentBase created event.
	 *
	 * @param  \App\Models\Commons\Voidx $voidx
	 *
	 * @return void
	 */
	public function created( Voidx $voidx ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate( [
			'table' => $this->table,
			'pk'    => $voidx->id,
		] );

	}

	/**
	 * Listen to the Part InstrumentBase event.
	 *
	 * @param  \App\Models\Commons\Voidx $voidx
	 *
	 * @return void
	 */
	public function saving( Voidx $voidx ) {
	}

	/**
	 * Listen to the InstrumentBase deleting event.
	 *
	 * @param  \App\Models\Commons\Voidx $voidx
	 *
	 * @return void
	 */
	public function deleting( Voidx $voidx ) {
		$voidx->pattern_void->delete();
	}
}