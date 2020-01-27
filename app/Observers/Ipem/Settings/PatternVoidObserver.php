<?php

namespace App\Observers\Ipem\Settings;

use App\Models\Commons\Security;
use App\Models\Ipem\Settings\PatternVoid;
use Illuminate\Http\Request;

class PatternVoidObserver {
	protected $request;
	protected $table = 'certificate_voids';

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	/**
	 * Listen to the InstrumentBase created event.
	 *
	 * @param  \App\Models\Ipem\Settings\PatternVoid $pattern_void
	 *
	 * @return void
	 */
	public function created( PatternVoid $pattern_void ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate( [
			'table' => $this->table,
			'pk'    => $pattern_void->id,
		] );
	}

	/**
	 * Listen to the InstrumentBase deleting event.
	 *
	 * @param  \App\Models\Ipem\Settings\PatternVoid $pattern_void
	 *
	 * @return void
	 */
	public function deleting( PatternVoid $pattern_void ) {
	}
}