<?php

namespace App\Traits\Billings;


use App\Models\Financials\Settings\PaymentForm;

trait PaymentFormTrait {

	public function getPaymentFormTextAttribute()
	{
		return PaymentForm::whereId($this->getAttribute('payment_form'))->description;
	}

	public function getTechnicalPaymentFormText()
	{
		return PaymentForm::whereId($this->getAttribute('technical_billing_issue_type_id'))->description;
	}

	public function getCommercialPaymentFormText()
	{
		return PaymentForm::whereId($this->getAttribute('commercial_billing_issue_type_id'))->description;
	}

}