<?php

namespace App\Models\Financials\Settings;

use App\Traits\VariablesTrait;

class PaymentDue
{
    const _STATUS_A_VISTA_ = 0;
    const _STATUS_PARCELADO_ = 1;
	use VariablesTrait;
	const _NAME_ = 'payment_dues';
}
