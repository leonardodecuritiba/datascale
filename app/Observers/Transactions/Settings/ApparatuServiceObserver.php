<?php

namespace App\Observers\Transactions;

use App\Models\Commons\Security;
use App\Models\Transactions\Settings\ApparatuService;
use Illuminate\Http\Request;

class ApparatuServiceObserver {
    protected $request;
    protected $table = 'apparatu_services';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Transactions\Settings\ApparatuService $apparatu_service
     *
     * @return void
     */
    public function created( ApparatuService $apparatu_service ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $apparatu_service->id,
	    ]);
	    //update O.S
	    $apparatu_service->apparatu->order->updateValues();


    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Transactions\Settings\ApparatuService $apparatu_service
	 *
	 * @return void
	 */
	public function deleting( ApparatuService $apparatu_service ) {
		//desfazer Apparatu.
		//regras pra atualizar os valores da O.S.
	}
	/**
	 * Listen to the ApparatuService deleted event.
	 *
	 * @param  \App\Models\Transactions\Settings\ApparatuService $apparatu_service
	 *
	 * @return void
	 */
	public function deleted( ApparatuService $apparatu_service ) {
		//regras pra atualizar os valores da O.S.
		$apparatu_service->apparatu->order->updateValues();
	}
}