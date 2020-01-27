<?php

namespace App\Traits\Orders;


use App\Helpers\DataHelper;
use Illuminate\Support\Collection;

trait OrderValuesTrait {

	public function getResumedValuesArray()
	{
		return [
			'services'      => $this->getTotalServicesFormatted(),
			'parts'         => $this->getTotalPartsFormatted(),
			'increase_tec'  => $this->getIncreaseTecFormatted(),
			'discount_tec'  => $this->getDiscountTecFormatted(),
			'total_value'   => $this->getTotalValueFormatted(),

			'travel_cost'   => $this->getTravelCostFormatted(),
			'tolls'         => $this->getTollsFormatted(),
			'other_cost'    => $this->getOtherCostFormatted(),

			'final_value'   => $this->getFinalValueFormatted()
		];
	}


	public function getTotalServicesFormatted() {
		return DataHelper::getFloat2Currency( $this->getTotalServices() );

	}

	public function getTotalPartsFormatted() {
		return DataHelper::getFloat2Currency( $this->getTotalParts() );

	}

	public function getIncreaseTecFormatted() {
		return DataHelper::getFloat2Currency( $this->getAttribute( 'increase_tec' ) );
	}

	public function getDiscountTecFormatted() {
		return DataHelper::getFloat2Currency( $this->getAttribute( 'discount_tec' ) );
	}

	public function getTotalValueFormatted() {
		return DataHelper::getFloat2Currency( $this->getAttribute( 'total_value' ) );
	}

	public function getTravelCostFormatted() {
		return DataHelper::getFloat2Currency( $this->getAttribute( 'travel_cost' ) );
	}

	public function getTollsFormatted() {
		return DataHelper::getFloat2Currency( $this->getAttribute( 'tolls' ) );
	}

	public function getOtherCostFormatted() {
		return DataHelper::getFloat2Currency( $this->getAttribute( 'other_cost' ) );
	}

	public function getFinalValueFormatted() {
		return DataHelper::getFloat2Currency( $this->getAttribute( 'final_value' ) );
	}
}