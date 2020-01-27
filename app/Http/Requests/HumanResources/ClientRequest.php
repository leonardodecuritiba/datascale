<?php

namespace App\Http\Requests\HumanResources;

use App\Models\HumanResources\Client;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest {
	private $table = 'clients';

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		/*
		contact_id
		address_id
		type
		*/
		$this->formatInput();

		if ( $this->get( 'type' ) ) {
			$rules = [
				'cnpj'          => 'required|min:3|max:20|unique:legal_people,cnpj',
				'ie'            => ( $this->get( 'exemption_ie' ) ) ? '' : 'required|min:3|max:20|unique:' . $this->table . ',ie',
				'fantasy_name'  => 'required|min:3|max:100',
				'social_reason' => 'required|min:3|max:100'
			];
			//juridica

		} else {
			//fisica
			$rules = [
				'cpf'       => 'required|min:3|max:20|unique:' . $this->table . ',cpf',
			];
		}
//		dd(date('d/m/Y'));
		$rules['responsible_name']  = 'required|min:3|max:100';
		$rules['city_id']           = 'required|exists:cep_cities,id';
		$rules['state_id']          = 'required|exists:cep_states,id';
		$rules['phone']             = 'required|min:10|max:11';

		if($this->has('picture') && $this->get('picture') != NULL){
			$size = config('system.pictures.size') * 1000;
			$rules['picture'] = 'max:' . $size . '|mimes:'  . config('system.pictures.mimes');
		}

//		dd($rules);
		switch ( $this->method() ) {
			case 'GET':
			case 'DELETE':
				{
					return [];
				}
			case 'POST':
				{
					return $rules;
				}
			case 'PUT':
			case 'PATCH':
				{
					$Client = Client::findOrFail($this->client);

					if ( $this->get( 'type' ) ) {
						$rules['cnpj'] = 'required|min:3|max:20|unique:legal_people,cnpj,' . $Client->legal_person_id . ',id';
						$rules['ie']   = ( $this->get( 'exemption_ie' ) == 1 ) ? '' : 'required|min:3|max:20|unique:legal_people,ie,' . $Client->legal_person_id . ',id';
						//juridica

					} else {
						//fisica
						$rules['cpf'] = 'required|min:3|max:20|unique:' . $this->table . ',cpf,' . $this->client . ',id';
					}

					return $rules;
				}
			default:
				break;
		}
	}

	public function formatInput() {
		if ( $this->has( 'exemption_ie' ) ) {
			$this->merge( [ 'exemption_ie' => 1 ] );
		} else {
			$this->merge( [ 'exemption_ie' => 0 ] );
		}
	}
}

