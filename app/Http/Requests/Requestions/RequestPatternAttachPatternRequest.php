<?php

namespace App\Http\Requests\Requestions;

use Illuminate\Foundation\Http\FormRequest;

class RequestPatternAttachPatternRequest extends FormRequest {

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
            'pattern_id'   => 'required|exists:patterns,id',
        ];
    }
}

