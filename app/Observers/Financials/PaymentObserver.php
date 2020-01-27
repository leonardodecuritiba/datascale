<?php

namespace App\Observers\Financials;

use App\Models\Commons\Security;
use App\Models\Financials\Payment;
use Illuminate\Http\Request;

class PaymentObserver {
    protected $request;
    protected $table = 'payments';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Billing created event.
     *
     * @param  \App\Models\Financials\Payment $payment
     *
     * @return void
     */
    public function created( Payment $payment ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $payment->id,
	    ]);
    }

	/**
	 * Listen to the Billing deleting event.
	 *
	 * @param  \App\Models\Financials\Payment $payment
	 *
	 * @return void
	 */
	public function deleting( Payment $payment ) {
		//desfazer parcelas
		$payment->portions->each(function($p){
			$p->delete();
		});

		Security::onDelete([
			'table' => $this->table,
			'pk'    => $payment->id,
		]);
	}
}