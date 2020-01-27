<?php

namespace App\Models\Ipem\Settings;

use App\Traits\VariablesTrait;

class PatternBrand
{
	const _STATUS_AGUARDANDO_ = 1;
	const _STATUS_ACEITA_ = 2;
	const _STATUS_NEGADA_ = 3;
	use VariablesTrait;
	const _NAME_ = 'pattern_brands';
}
