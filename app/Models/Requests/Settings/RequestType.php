<?php

namespace App\Models\Requests\Settings;

use App\Traits\VariablesTrait;

class RequestType
{
	const _TYPE_LABELS_ = 1;
	const _TYPE_SEALS_ = 2;
	const _TYPE_PATTERNS_ = 3;
	const _TYPE_TOOLS_ = 4;
	const _TYPE_EQUIPMENTS_ = 5;
	const _TYPE_VEHICLES_ = 6;
	const _TYPE_PARTS_ = 7;

	use VariablesTrait;
	const _NAME_ = 'request_types';
}
