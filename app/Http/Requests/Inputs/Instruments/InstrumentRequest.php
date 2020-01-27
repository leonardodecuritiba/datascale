<?php

namespace App\Http\Requests\Inputs\Instruments;

use App\Models\Inputs\Instruments\Instrument;
use Illuminate\Foundation\Http\FormRequest;

class InstrumentRequest extends FormRequest {
	private $table = 'instruments';

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
		$id = $this->get('id');
		$client_id = $this->get('client_id');
		$rules = [
			'pam_id'                => 'required|exists:pams,id',
			'instrument_setor_id'   => 'required|exists:instrument_setors,id',
			'year'              => 'required|digits:4',
            'serial_number'     => 'required|min:1|max:50|unique_client:' . $this->table . ',serial_number,client_id,' . $client_id,
            'patrimony'         => 'present|min:1|max:50|unique_client:' . $this->table . ',patrimony,client_id,' . $client_id,
            'inventory'         => 'present|min:1|max:50|unique_client:' . $this->table . ',inventory,client_id,' . $client_id,
            'ip'                => 'present|ip|unique_client:' . $this->table . ',ip,client_id,' . $client_id,
            'address'           => 'present|unique_client:' . $this->table . ',address,client_id,' . $client_id,
		];

		if($id > 0){
			$rules['serial_number'] .= ',id,' . $id;
			$rules['serial_number'] .= ',id,' . $id;
			$rules['patrimony']     .= ',id,' . $id;
			$rules['inventory']     .= ',id,' . $id;
			$rules['ip']            .= ',id,' . $id;
			$rules['address']       .= ',id,' . $id;
		} else {
			$rules['client_id'] = 'required|exists:clients,id';
		}

		if($this->has('picture') && $this->get('picture') != NULL){
			$size = config('system.pictures.size') * 1000;
			$rules['picture'] = 'max:' . $size . '|mimes:'  . config('system.pictures.mimes');
		}

		return $rules;
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

