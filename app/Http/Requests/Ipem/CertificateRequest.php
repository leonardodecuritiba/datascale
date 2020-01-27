<?php

namespace App\Http\Requests\Ipem;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest {
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
		$size  = config( 'system.pdfs.size' ) * 1000;
		$rules = [
			'number'      => 'required|min:1|max:50',
			'file'        => 'required|max:' . $size . '|mimes:' . config( 'system.pdfs.mimes' ),
			'verified_at' => 'required',
			'due_at'      => 'required'
		];

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
					return $rules;
				}
			default:
				break;
		}
	}
}

