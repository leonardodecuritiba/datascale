<?php

namespace App\Http\Requests\Parts;

use App\Models\Parts\Settings\Cfop;
use App\Models\Parts\Settings\Cst;
use App\Models\Parts\Settings\NatureOperation;
use App\Models\Parts\Settings\Unity;
use Illuminate\Foundation\Http\FormRequest;

class PartRequest extends FormRequest {
	private $table = 'parts';

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
			'provider_id'           => 'required|exists:providers,id',
			'brand_id'              => 'required|exists:brands,id',
			'group_id'              => 'required|exists:groups,id',
            //image 'picture'      => 'required|image',
			'unity_id'              => 'required|in:' . implode(',', Unity::all()->pluck('id')->toArray()),
			'type'                  => 'required|in:' .implode(',', ['part','product']),

			'auxiliar_code'         => 'required|max:50',
			'bar_code'              => 'required|max:50',
			'description'           => 'required|max:100',
			'technical_description' => 'required|max:100',

			'sub_group'            => 'max:50',
			'warranty'             => 'required',
			'technical_commission' => 'required',
			'seller_commission'    => 'required',

            //taxation
			'ncm_id'               => 'required|exists:ncms,id',
			'cfop_id'              => 'required|in:' . implode(',', Cfop::all()->pluck('id')->toArray()),
			'cst_id'               => 'required|in:' . implode( ',', Cst::all()->pluck( 'id' )->toArray() ),
			'nature_operation_id'  => 'required|in:' . implode(',', NatureOperation::all()->pluck('id')->toArray()),

			'cest'                  => 'required|max:10',
			'icms_base_calculo'     => 'required',
			'icms_valor_total'      => 'required',
			'icms_base_calculo_st'  => 'required',
			'icms_valor_total_st'   => 'required',

			'icms_origem'               => 'required|max:1',
			'icms_situacao_tributaria'  => 'required|max:3',
			'pis_situacao_tributaria'   => 'required|max:2',
			'cofins_situacao_tributaria'=> 'required|max:2',


			'valor_unitario_comercial'  => 'required',
			'unidade_tributavel'        => 'required',
			'valor_unitario_tributavel' => 'required',

			'valor_ipi'                 => 'required',

			'valor_frete'               => 'required',
			'valor_seguro'              => 'required',
			'valor_total'               => 'required',

        ];
		if($this->has('picture') && $this->get('picture') != NULL){
			$size = config('system.pictures.size') * 1000;
			$rules['picture'] = 'max:' . $size . '|mimes:'  . config('system.pictures.mimes');
		}


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

