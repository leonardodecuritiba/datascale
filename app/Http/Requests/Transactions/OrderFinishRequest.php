<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class OrderFinishRequest extends FormRequest {
	private $table = 'orders';

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

		if($this->has('exemption_cost')) {
			$this->merge(['exemption_cost' => 1]);
		}
		return [
			'responsible'           => 'required|min:3|max:100',
			'responsible_cpf'       => 'required|min:3|max:16',
			'responsible_position'  => 'required|min:3|max:50'
		];
	}
}

