<?php

namespace App\Filters;

use App\Helpers\DataHelper;
use App\Models\Financials\Settings\BillingTypes;
use App\Models\HumanResources\Settings\LegalPerson;
use Illuminate\Http\Request;

class BillingFilter
{
	public $entity;

	public function filter(Request $request)
	{
		set_time_limit(60 * 60 * 5);
		$filter = $this->entity;

		if($request->has('search_id') && $request->has('billing_id') && ($request->get('billing_id') != '')){
			$request->request->remove('type');
			$request->request->remove('status');
			$request->request->remove('client_id');
			$filter = $filter->where('id', $request->get('billing_id'));
		} else {
			$request->request->remove('billing_id');
			if ($request->get('type') == 1) { //CLIENTE
				$filter->clients();
			} else {
				$filter->costCenter();
			}

			$fields = ['client_id','status'];
			foreach($fields as $field)
			{
				if ($request->has($field) && ($request->get($field) != '')) {
					$filter = $filter->where( $field, $request->get( $field ) );
				}
			}
			$filter->orderBy('created_at', 'desc');
		}
		return $filter;
	}

	public function map(Request $request, $entity, $pagination = false)
	{
		$this->entity = $entity;
		if($request->has('search') || $request->has('search_id')){
			$filter = $this->filter($request);

			if(!is_a($filter, 'Illuminate\Database\Eloquent\Collection')) {
				$filter = $filter->with('client')->get()->map( function ( $s ) {
					$client = $s->client;
					return [
						'id'                => $s->id,
						'name'              => " #" . $s->id,
						'created_at'        => $s->created_at_formatted,
						'created_at_time'   => $s->created_at_time,

						'payment_text'      => $client->getTechnicalPaymentFormText(),
						'quantity_orders'   => $s->orders->count(),

						'document_text'     => $client->short_document,
						'client_text'       => $client->getName(),
						'client_id'         => $client->id,

						'status_icon'       => $s->status_icon,
						'status_color'      => $s->status_color,
						'status_text'       => $s->status_text,
					];
				} );
			};
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
			return $filter->map(function($s){
				return $s;
			});
		} else {
			return [];
		}
	}

}
