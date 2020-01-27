<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Security;
use App\Models\Parts\Service;
use Illuminate\Http\Request;

class ServiceObserver {
    protected $request;
	protected $table = 'services';

    public function __construct( Request $request ) {
        $this->request = $request;
    }
    /**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Parts\Service $servico
     *
     * @return void
     */
    public function created( Service $servico ) {
        //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $servico->id,
	    ]);

    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Parts\Service $servico
	 *
	 * @return void
	 */
	public function deleting( Service $servico ) {
//        $servico->servico_prestados()->delete();
		$servico->prices->each(function ($p){
			$p->delete();
		});
		$servico->apparatu_services->each(function ($p){
			$p->delete();
		});
	}
}