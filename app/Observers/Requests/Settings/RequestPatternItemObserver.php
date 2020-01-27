<?php

namespace App\Observers\Requests\Settings;

use App\Models\Commons\Security;
use App\Models\Requests\Settings\RequestPatternItem;
use Illuminate\Http\Request;

class RequestPatternItemObserver {
	protected $request;
	protected $table = 'request_pattern_itens';

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	/**
	 * Listen to the InstrumentBase created event.
	 *
	 * @param  \App\Models\Requests\Settings\RequestPatternItem $request_pattern_item
	 *
	 * @return void
	 */
	public function created( RequestPatternItem $request_pattern_item ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate( [
			'table' => $this->table,
			'pk'    => $request_pattern_item->id,
		] );
	}

	/**
	 * Listen to the InstrumentBase deleting event.
	 *
	 * @param  \App\Models\Requests\Settings\RequestPatternItem $request_pattern_item
	 *
	 * @return void
	 */
	public function deleting( RequestPatternItem $request_pattern_item ) {
	}
}