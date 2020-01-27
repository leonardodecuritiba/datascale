<?php

namespace App\Observers\Financials;

use App\Models\Commons\Security;
use App\Models\Financials\Billing;
use App\Models\Transactions\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingObserver {
    protected $request;
    protected $table = 'billings';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Billing created event.
     *
     * @param  \App\Models\Financials\Billing $billing
     *
     * @return void
     */
    public function created( Billing $billing ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $billing->id,
	    ]);
    }

	/**
	 * Listen to the Billing deleting event.
	 *
	 * @param  \App\Models\Financials\Billing $billing
	 *
	 * @return void
	 */
	public function deleting( Billing $billing ) {
		//desfazer O.S.
		$orders_id = $billing->orders->pluck('id')->toArray();
		DB::table('orders')
		  ->whereIn('id', $orders_id)
		  ->update([
			  'billing_id'    => NULL,
			  'status'        => Order::$_STATUS_FATURAMENTO_PENDENTE_
		  ]);
		//desfazer pagamento
		$billing->payment->delete();

		Security::onDelete([
			'table' => $this->table,
			'pk'    => $billing->id,
		]);
	}
}