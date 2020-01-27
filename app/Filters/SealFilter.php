<?php

namespace App\Filters;

use App\Helpers\DataHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SealFilter
{
	public $entity;

	public function filter(Request $request)
	{
		set_time_limit(60 * 60 * 5);
		$filter = $this->entity;

		if($request->get('status') <= 2){ //USADO OU NÃO
			$filter->where('used', $request->get('status') - 1);
		}

		if($request->has('number') && $request->get('number') != NULL)
		{
			$filter->where('number', 'like','%' .DataHelper::getOnlyNumbers($request->get('number')). '%');
		}

		if($request->has('owner_id') && $request->get('owner_id') != NULL)
		{
			$filter->where('owner_id', $request->get('owner_id'));
		}

		if(
			($request->has('cnpj') && $request->get('cnpj') != NULL) ||
			($request->has('serial_number') && $request->get('serial_number') != NULL) ||
			($request->has('inventory') && $request->get('inventory') != NULL) ||
			($request->has('order_id') && $request->get('order_id') != NULL)
		){

			$order_id       = DataHelper::getOnlyNumbers( $request->get('order_id') );
			$cnpj           = DataHelper::getOnlyNumbers( $request->get('cnpj') );
			$serial_number  = DataHelper::getOnlyNumbers( $request->get('serial_number') );
			$inventory      = DataHelper::getOnlyNumbers( $request->get('inventory') );

			$query = DB::table( 'seal_instruments' )
			           ->join( 'apparatus', function ( $join ) {
				           $join->on( 'apparatus.id', '=', 'seal_instruments.apparatu_set_id' )
				                ->orOn( 'apparatus.id', '=', 'seal_instruments.apparatu_unset_id' );
			           });

			if($order_id!='' || $cnpj!='') {
				$query->join( 'orders', 'orders.id', '=', 'apparatus.order_id' );

				if($cnpj!='') {
					$query->join( 'clients', 'clients.id', '=', 'orders.client_id' )
					      ->join( 'legal_people', 'legal_people.id', '=', 'clients.legal_person_id' )
					      ->select( 'seal_instruments.seal_id' )
					      ->where( 'legal_people.cnpj', 'like', '%' . $cnpj . '%' );
				}

				if($order_id!='') {
					$query->where( 'orders.id', $order_id );
				}

			}
			if($serial_number!='' || $inventory!='') {
				$query->join( 'instruments', 'instruments.id', '=', 'apparatus.instrument_id' );
				if($serial_number!='') {
					$query->where('instruments.serial_number', 'like','%' .$serial_number. '%');
				}

				if($inventory!='') {
					$query->where('instruments.inventory', 'like','%' .$inventory. '%');
				}
			}

			$filter->whereIn( 'id', $query->pluck( 'seal_id' ) );
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


					$seal_instrument = $s->seal_instrument;
					if($seal_instrument!=NULL){
						$instrument         = $seal_instrument->instrument;
						$client             = $instrument->client;
						$order_setted_id    = ($seal_instrument->apparatu_set_id != NULL) ? $seal_instrument->apparatu_set->order_id : NULL;
						$order_unsetted_id  = ($seal_instrument->apparatu_unset_id != NULL) ? $seal_instrument->apparatu_unset->order_id : NULL;
						$inventory          = $instrument->inventory;
						$serial_number      = $instrument->serial_number;
					} else {
						$client             = NULL;
						$order_setted_id    = NULL;
						$order_unsetted_id  = NULL;
						$inventory          = NULL;
						$serial_number      = NULL;
					}

					return [
						'id'                => $s->id,
						'name'              => " #" . $s->id,
						'created_at'        => $s->created_at_formatted,
						'created_at_time'   => $s->created_at_time,
						'owner_name'        => $s->owner->name,
						'number'            => $s->number_formatted,
						'is_external'       => $s->isExternal(),

						'client_text'       => optional($client)->short_document,
						'client_id'         => optional($client)->id,

						'order_setted_id'   => $order_setted_id,
						'order_unsetted_id' => $order_unsetted_id,
						'serial_number'     => $serial_number,
						'inventory'         => $inventory,

						'status_color'      => $s->status_color,
						'status_text'       => $s->status_text,
					];
				} );
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
			return $filter->map(function($s){
				return $s;
			});
		} else {
			return [];
		}
	}


}
