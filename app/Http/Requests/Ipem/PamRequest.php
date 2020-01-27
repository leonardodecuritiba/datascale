<?php

namespace App\Http\Requests\Ipem;

use Illuminate\Foundation\Http\FormRequest;

class PamRequest extends FormRequest {
	private $table = 'pams';

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
		$rules = [
			'instrument_model_id'  => 'required|exists:instrument_models,id',
			'division'              => 'required|min:1|max:100',
			'ordinance'             => 'required|min:1|max:100',
			'capacity'              => 'required|min:1|max:100'
		];
		if($this->has('picture') && $this->get('picture') != NULL){
			$size = config('system.pictures.size') * 1000;
			$rules['picture'] = 'max:' . $size . '|mimes:'  . config('system.pictures.mimes');
		}
		switch ( $this->method() ) {
			case 'GET':
			case 'DELETE':
				{
					return [];
				}
			case 'POST':
				{
					$rules['description'] = 'required|unique:'.$this->table;
					return $rules;
				}
			case 'PUT':
			case 'PATCH':
				{
					$rules['description'] = 'unique:'.$this->table.',description,'.$this->pam.',id';
					return $rules;
				}
			default:
				break;
		}
	}
}

