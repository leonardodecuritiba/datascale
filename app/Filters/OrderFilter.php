<?php

namespace App\Filters;

use App\Helpers\DataHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderFilter
{
	public $entity;

	public function filter(Request $request)
	{
		set_time_limit(60 * 60 * 5);
		$filter = $this->entity;

		if($request->has('order_id') && ($request->get('order_id') != '')){
			$fields = ['created_at_start','status', 'client_id'];
			foreach($fields as $field)
			{
				$request->request->remove($field);
			}
			$filter = $filter->where('id', $request->get('order_id'));
		} else {
			$request->request->remove('order_id');
			$fields = ['client_id','status'];
			foreach($fields as $field)
			{
				if ($request->has($field) && ($request->get($field) != '')) {
                    $filter = $filter->where( $field, $request->get( $field ) );
				}
			}

			if ($request->has('created_at_start') && ($request->get('created_at_start') != '')) {
				$cr = DataHelper::setDate($request->get( 'created_at_start' ));
				if($cr != NULL) $filter = $filter->where( 'created_at', '>=', $cr );
			}

		}
		return $filter;
	}

	public function map(Request $request, $entity, $pagination = false)
	{
		$this->entity = $entity;
		if($request->has('search') || $request->has('search_id')){
			$filter = $this->filter($request, $pagination);

			if(!is_a($filter, 'Illuminate\Database\Eloquent\Collection')) {
				$filter = $filter->get()->map( function ( $s ) {
					return [
						'id'                => $s->id,
						'name'              => " #" . $s->id,
						'status'            => $s->status,
						'status_color'      => $s->status_color,
						'status_icon'       => $s->status_icon,
						'status_text'       => $s->status_text,
//						'call_number'       => $s->call_number,
						'created_at'        => $s->created_at_formatted,
						'created_at_time'   => $s->created_at_time,
						'owner_name'        => $s->owner->name,
						'client_id'         => $s->client_id,
						'client_name'       => $s->client->fantasy_name_text,

						'can_show_bill_btn' => $s->canShowBillBtn(),


						'period'            => $s->getPeriodText()
					];
				} )->groupBy('period');
			}
		} else {
			$filter = NULL;
		}

		if($filter != NULL){
			if($pagination){
				return [
					'filter'=>$filter,
					'items' =>$filter->getCollection()->transform(function($s){
						return $s;
					})
				];
			}

			$current = Carbon::now()->format( 'm/Y' );
			if ( key_exists( $current, $filter ) ) {
				$current_orders = $filter[ $current ];
				unset( $filter[ $current ] );
			} else {
				$current_orders = NULL;
			}
			return [
				'past_orders'    => $filter,
				'current_orders' => $current_orders,
			];

		} else {
			return [];
		}
	}

}
