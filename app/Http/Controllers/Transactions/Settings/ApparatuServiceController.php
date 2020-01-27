<?php

namespace App\Http\Controllers\Transactions\Settings;

use App\Http\Controllers\Controller;
use App\Models\Transactions\Order;

class ApparatuServiceController extends Controller
{

	/**
	 * Values of an Order.
	 * @param \App\Models\Transactions\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function values(Order $order)
	{
//    	return $order;
		return [
			'services'      => $order->getTotalServicesFormatted(),
			'parts'         => $order->getTotalPartsFormatted(),
			'increase_tec'  => $order->getIncreaseTecFormatted(),
			'discount_tec'  => $order->getDiscountTecFormatted(),
			'total_value'   => $order->getTotalValueFormatted(),


			'travel_cost'   => $order->getTravelCostFormatted(),
			'tolls'         => $order->getTollsFormatted(),
			'other_cost'    => $order->getOtherCostFormatted(),

			'final_value'   => $order->getFinalValueFormatted()
		];

	}
}
