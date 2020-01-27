<?php

namespace App\Http\Requests\Requestions;

use Illuminate\Foundation\Http\FormRequest;

class RequestPatternRequest extends FormRequest {
    private $table = 'request_patterns';

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
                        'type'     => 'required|min:1|max:4',
                        'reason'   => 'required|min:3|max:1000',
                        'value'   => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'type'     => 'required|min:1|max:4',
                        'reason'   => 'required|min:3|max:1000',
                    ];
                }
            default:
                break;
        }
    }
}