<?php

namespace App\Filters;

use App\Helpers\DataHelper;
use App\Models\HumanResources\Settings\LegalPerson;
use Illuminate\Http\Request;

class ClientFilter
{
	public $entity;

	public function filter(Request $request)
	{
		set_time_limit(60 * 60 * 5);
		$filter = $this->entity;

		if($request->has('search_id') && $request->has('client_id') && ($request->get('client_id') != '')){
			$request->request->remove('description');
			$filter = $filter->where('id', $request->get('client_id'));
		} else {
			$request->request->remove('client_id');
			$search = $request->get('description');

			if ($search != '') {
				//$filter
				$numbers = DataHelper::getOnlyNumbers($search);
				$ids = LegalPerson::where('social_reason', 'like', '%' . $search . '%')
				                  ->orWhere('fantasy_name', 'like', '%' . $search . '%');
				if ($numbers != '') {
					$ids = $ids->orWhere('cnpj', 'like', '%' . $numbers . '%');
				}
				$ids = $ids->pluck('id');
				if($ids->count() > 0){
					$filter->whereIn('legal_person_id', $ids);
				} else {
					$filter->where('legal_person_id', 0);
				}
			}
		}
		return $filter;
	}

	public function map(Request $request, $entity, $pagination = false)
	{
		$this->entity = $entity;
		if($request->has('search') || $request->has('search_id')){
			$filter = $this->filter($request);

			if(!is_a($filter, 'Illuminate\Database\Eloquent\Collection')) {
				$filter = $filter->with('contact', 'legal_person', 'picture')->get()->map( function ( $s ) {
					return [
						'id'                    => $s->id,
						'image'                 => $s->getThumbFileView(),
						'responsible_name'      => $s->responsible_name,
						'fantasy_name_text'     => $s->fantasy_name_text,
						'social_reason_text'    => $s->social_reason_text,
						'short_document'        => $s->short_document,
						'content'               => $s->short_description,
						'name'                  => $s->responsible_name,
						'phone'                 => $s->contact->phone_formatted,
						'created_at'            => $s->created_at_formatted,
						'created_at_time'       => $s->created_at_time,
						'active'                => $s->getActiveFullResponse()
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
