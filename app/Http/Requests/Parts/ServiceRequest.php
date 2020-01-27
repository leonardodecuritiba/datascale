<?php

namespace App\Http\Requests\Parts;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest {
	private $table = 'services';

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
                        'group_id'      => 'required|exists:groups,id',
                        'name'          => 'required|unique:'.$this->table.'|max:100',
                        'description'   => 'required|max:255',
                        'value'         => 'required',
					];
				}
			case 'PUT':
			case 'PATCH':
				{
					return [
                        'group_id'      => 'required|exists:groups,id',
                        'name'          => 'unique:'.$this->table.',name,'.$this->service.',id|max:100',
                        'description'   => 'required|max:255',
                        'value'         => 'required',
					];
				}
			default:
				break;
		}
	}
}

