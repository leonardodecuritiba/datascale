<?php

namespace App\Observers\Transactions;

use App\Models\Commons\Security;
use App\Models\Transactions\Settings\ApparatuPart;
use Illuminate\Http\Request;

class ApparatuPartObserver {
    protected $request;
    protected $table = 'apparatu_parts';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Transactions\Settings\ApparatuPart $apparatu_part
     *
     * @return void
     */
    public function created( ApparatuPart $apparatu_part ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $apparatu_part->id,
	    ]);
	    $apparatu_part->apparatu->order->updateValues();
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Transactions\Settings\ApparatuPart $apparatu_part
	 *
	 * @return void
	 */
	public function deleting( ApparatuPart $apparatu_part ) {
		//desfazer Apparatu.
		//regras pra atualizar os valores da O.S.
	}
	/**
	 * Listen to the ApparatuPart deleted event.
	 *
	 * @param  \App\Models\Transactions\Settings\ApparatuPart $apparatu_part
	 *
	 * @return void
	 */
	public function deleted( ApparatuPart $apparatu_part ) {
		//desfazer Apparatu.
		//regras pra atualizar os valores da O.S.
		$apparatu_part->apparatu->order->updateValues();
	}
}