<?php

namespace App\Http\Requests\Parts;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest {
	private $table = 'prices';

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
		switch ( $this->method() ) {
			case 'GET':
			case 'DELETE':
				{
					return [];
				}
			case 'POST':
				{
					return [
                        'name'          => 'required|unique:'.$this->table.'|max:100',
                        'description'   => 'required|max:255',
					];
				}
			case 'PUT':
			case 'PATCH':
				{
					return [
                        'name'          => 'unique:'.$this->table.',name,'.$this->price.',id|max:100',
                        'description'   => 'required|max:255',
					];
				}
			default:
				break;
		}
	}
}

