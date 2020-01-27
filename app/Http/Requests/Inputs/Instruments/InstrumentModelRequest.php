<?php

namespace App\Http\Requests\Inputs\Instruments;

use Illuminate\Foundation\Http\FormRequest;

class InstrumentModelRequest extends FormRequest {
	private $table = 'instrument_models';

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
                        'instrument_brand_id'  => 'required|exists:instrument_brands,id',
					];
				}
			case 'PUT':
			case 'PATCH':
				{
					return [
                        'description'          => 'unique:'.$this->table.',description,'.$this->instrument_model.',id',
                        'instrument_brand_id'  => 'required|exists:instrument_brands,id',
					];
				}
			default:
				break;
		}
	}
}

