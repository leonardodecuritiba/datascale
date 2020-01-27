<?php

namespace App\Observers\Requests;

use App\Models\Commons\Security;
use App\Models\Requests\RequestPattern;
use App\Models\Requests\Settings\RequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestPatternObserver {
	protected $request;
	protected $table = 'request_patterns';

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	/**
	 * Listen to the InstrumentBase created event.
	 *
	 * @param  \App\Models\Requests\RequestPattern $request_pattern
	 *
	 * @return void
	 */
	public function created( RequestPattern $request_pattern ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate( [
			'table' => $this->table,
			'pk'    => $request_pattern->id,
		] );
	}
    /**
     * Listen to the Order creating event.
     *
     * @param  \App\Models\Requests\RequestPattern $request_pattern
     *
     * @return void
     */
    public function creating( RequestPattern $request_pattern )
    {
        $request_pattern->requester_id = Auth::id();
        $request_pattern->status = RequestStatus::_STATUS_AGUARDANDO_;
    }

	/**
	 * Listen to the Part InstrumentBase event.
	 *
	 * @param  \App\Models\Requests\RequestPattern $request_pattern
	 *
	 * @return void
	 */
	public function saving( RequestPattern $request_pattern ) {
	}

	/**
	 * Listen to the InstrumentBase deleting event.
	 *
	 * @param  \App\Models\Requests\RequestPattern $request_pattern
	 *
	 * @return void
	 */
	public function deleting( RequestPattern $request_pattern ) {
		$request_pattern->itens->each( function ( $p ) {
			$p->delete();
		} );
	}
}