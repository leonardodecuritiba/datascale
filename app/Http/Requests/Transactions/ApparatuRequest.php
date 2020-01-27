<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class ApparatuRequest extends FormRequest {
	private $table = 'apparatus';

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
					return [];
				}
			case 'PUT':
			case 'PATCH':
				{
					return [
						'defect'    => 'required|min:3|max:500',
						'solution'  => 'required|min:3|max:500'
					];
				}
			default:
				break;
		}
	}
}

