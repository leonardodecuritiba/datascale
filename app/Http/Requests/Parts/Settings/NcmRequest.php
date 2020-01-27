<?php

namespace App\Http\Requests\Parts\Settings;

use Illuminate\Foundation\Http\FormRequest;

class NcmRequest extends FormRequest {
	private $table = 'ncms';

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
                        'code'          => 'required|unique:'.$this->table,
                        'description'   => 'required',
                        'ipi'           => 'required',
                        'pis'           => 'required',
                        'cofins'        => 'required',
                        'nacional'      => 'required',
                        'importacao'    => 'required'
					];
				}
			case 'PUT':
			case 'PATCH':
				{
					return [
                        'code'          => 'unique:'.$this->table.',code,'.$this->ncm.',id',
                        'description'   => 'required',
                        'ipi'           => 'required',
                        'pis'           => 'required',
                        'cofins'        => 'required',
                        'nacional'      => 'required',
                        'importacao'    => 'required'
					];
				}
			default:
				break;
		}
	}
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cover.required' => 'A imagem é obrigatória',
        ];
    }
}

