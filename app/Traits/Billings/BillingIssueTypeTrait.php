<?php

namespace App\Traits\Billings;


use App\Models\Financials\Settings\BillingIssueType;

trait BillingIssueTypeTrait {

	static public $_TIPO_BOLETO_NFE_NFSE_ = 1;
	static public $_TIPO_BOLETO_NFSE_AGREGADO_PECA_ = 2;
	static public $_TIPO_BOLETO_ = 3;

	public function getTechnicalBillingIssueTypeText()
	{
		return BillingIssueType::whereId($this->getAttribute('technical_billing_issue_type_id'))->description;
	}

	public function getCommercialBillingIssueTypeText()
	{
		return BillingIssueType::whereId($this->getAttribute('commercial_billing_issue_type_id'))->description;
	}

}