<?php

namespace App\Http\Requests\Ipem;

use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends FormRequest {

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
		$num_begin = $this->get('num_begin');
		return [
			'user_id'   => 'required|exists:users,id',
			'num_begin' => 'required_with:num_end|integer|min:1',
			'num_end'   => 'required_with:num_begin|integer|min:' . ($num_begin + 1)
		];
	}
}

