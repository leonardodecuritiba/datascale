<?php

namespace App\Models\Inputs\Settings;

use App\Traits\VariablesTrait;

class LabelSealStatus
{
	const _STATUS_DISPONIVEL_ = 1;
	const _STATUS_USADO_ = 2;
	use VariablesTrait;
	const _NAME_ = 'label_seal_status';
}
