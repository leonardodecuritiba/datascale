<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Parts\Settings\Ncm;
use Illuminate\Http\Request;

class NcmObserver {
	protected $request;
	protected $table = 'ncms';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Parts\Settings\Ncm $ncm
	 *
	 * @return void
	 */
	public function created( Ncm $ncm ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate([
			'table' => $this->table,
			'pk'    => $ncm->id,
		]);
	}

	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Parts\Settings\Ncm $ncm
	 *
	 * @return void
	 */
	public function deleting( Ncm $ncm ) {
        $ncm->parts->each(function ($p){
            $p->delete();
        });
	}
}