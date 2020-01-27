<?php

namespace App\Observers\Transactions;

use App\Models\Commons\Security;
use App\Models\Transactions\Order;
use Illuminate\Http\Request;

class OrderObserver {
    protected $request;
    protected $table = 'orders';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Transactions\Order $order
     *
     * @return void
     */
    public function created( Order $order ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $order->id,
	    ]);
    }
	/**
     * Listen to the Order creating event.
     *
     * @param  \App\Models\Transactions\Order $order
     *
     * @return void
     */
    public function creating( Order $order )
    {
	    $order->final_value =
		    $order->getAttribute('total_value') +
		    $order->getAttribute('travel_cost') +
		    $order->getAttribute('tolls') +
		    $order->getAttribute('other_cost');
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Transactions\Order $order
	 *
	 * @return void
	 */
	public function deleting( Order $order ) {
		//desfazer O.S.
		$order->apparatus->each(function($a){
			$a->delete();
		});
	}
}