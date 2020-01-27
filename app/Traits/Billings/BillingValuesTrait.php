<?php

namespace App\Traits\Billings;


use App\Helpers\DataHelper;
use Illuminate\Support\Collection;

trait BillingValuesTrait {


	static public function getValuesClosing(Collection $Orders)
	{
		$_VALORES = [
			'increase_tec' => 0,
			'discount_tec' => 0,

			'services_discount' => 0,
			'parts_discount' => 0,
			'services' => 0,
			'parts' => 0,

			'other_cost' => 0,
			'travel_cost' => 0,
			'tolls' => 0,
			'outras_despesas' => 0,
			'total_value' => 0,
			'final_value' => 0,
		];
		$values = $Orders->map(function ($os) {
			$services = $os->getTotalServices();
			$parts = $os->getTotalParts();

			$services_discount = $os->getTotalDiscountServices();
			$parts_discount = $os->getTotalDiscountParts();
			return [
				'increase_tec'                  => $os->increase_tec,
				'discount_tec'                  => $os->discount_tec,

				'services_discount'       => $services_discount,
				'parts_discount'          => $parts_discount,
				'services'                => $services,
				'parts'                   => $parts,

				'other_cost'                    => $os->other_cost,
				'travel_cost'                   => $os->travel_cost,
				'tolls'                         => $os->tolls,
				'outras_despesas'               => $os->other_cost + $os->travel_cost + $os->tolls,
				'total_value'                   => $os->total_value,
				'final_value'                   => $os->final_value,
			];
		});

		foreach ($values as $val) {
			foreach ($val as $key => $value) {
				$_VALORES[$key] += floatval($val[$key]);
			}
		}
		return $_VALORES;
	}

	public function getValues()
	{
		$values = self::getValuesClosing($this->orders);

		switch ($this->client->technical_billing_issue_type_id) {
			case BillingIssueTypeTrait::$_TIPO_BOLETO_NFE_NFSE_:
				$values['nfse_value'] = $values['outras_despesas'] + $values['services'];
				break;
			case BillingIssueTypeTrait::$_TIPO_BOLETO_NFSE_AGREGADO_PECA_:
				$values['nfse_value'] = $values['final_value'];
				break;
			default:
				$values['nfse_value'] = 0;
				break;
		}

		return $values;
	}

	public function getResumedValuesArray()
	{
		return DataHelper::getVectorKeyFloat2Currency($this->getValues());
	}

}