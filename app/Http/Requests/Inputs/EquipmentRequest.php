<?php

namespace App\Http\Requests\Inputs;

use App\Models\Inputs\Equipment;
use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest {
	private $table = 'equipments';

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
			'brand_id'      => 'required|exists:brands,id',
			'description'   => 'required|min:1|max:100',
			'model'         => 'required|min:1|max:100',
			'serial_number' => 'required|min:1|max:50',
		];

		if($this->has('picture') && $this->get('picture') != NULL){
			$size = config('system.pictures.size') * 1000;
			$rules['picture'] = 'max:' . $size . '|mimes:'  . config('system.pictures.mimes');
		}

//		dd($rules);
		return $rules;
		/*

        switch ( $this->method() ) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
	            return $rules;
            }
            case 'PUT':
            case 'PATCH': {
	            $rules['description'] = 'required|min:1|max:50|unique:' . $this->table . ',description,' . $id . ',id';
	            return $rules;
            }
            default:
                break;
        }
		*/
	}
    /**
     * Get the response that handle the request errors.
     *
     * @param  array $errors
     *
     * @return array
     */
    public function response( array $errors ) {
        return response()->error($errors);
    }
}

