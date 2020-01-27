<?php

namespace App\Http\Requests\Ipem;

use Illuminate\Foundation\Http\FormRequest;

class CertificateAttachPatternRequest extends FormRequest {
	private $table = 'certificates';

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
		return [
			'model_id'   => 'required',
			'brand_id'   => 'required',
			'feature_id' => 'required',
			'voids'      => 'required|min:1',
			'mass'       => 'required|integer|min:1',
		];
	}
}

