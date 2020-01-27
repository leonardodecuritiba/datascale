<?php

namespace App\Observers\Ipem;

use App\Models\Commons\Security;
use App\Models\Ipem\Pattern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatternObserver {
	protected $request;
	protected $table = 'patterns';

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	/**
	 * Listen to the InstrumentBase created event.
	 *
	 * @param  \App\Models\Ipem\Pattern $pattern
	 *
	 * @return void
	 */
	public function created( Pattern $pattern ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate( [
			'table' => $this->table,
			'pk'    => $pattern->id,
		] );

	}

	/**
	 * Listen to the Part InstrumentBase event.
	 *
	 * @param  \App\Models\Ipem\Pattern $pattern
	 *
	 * @return void
	 */
	public function saving( Pattern $pattern ) {
		// //testar
		if ( $pattern->owner_id == null ) {
			$pattern->owner_id = Auth::id();
		}
	}

	/**
	 * Listen to the InstrumentBase deleting event.
	 *
	 * @param  \App\Models\Ipem\Pattern $pattern
	 *
	 * @return void
	 */
	public function deleting( Pattern $pattern ) {
		$pattern->certificate_pattern->delete();
		$pattern->pattern_void->delete();
		$pattern->request_pattern_item->delete();
	}
}