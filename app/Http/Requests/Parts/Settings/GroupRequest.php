<?php

namespace App\Http\Requests\Parts\Settings;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest {
	private $table = 'groups';

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
                        'description'          => 'required|unique:'.$this->table,
					];
				}
			case 'PUT':
			case 'PATCH':
				{
					return [
                        'description'          => 'unique:'.$this->table.',description,'.$this->group.',id',
					];
				}
			default:
				break;
		}
	}
}

