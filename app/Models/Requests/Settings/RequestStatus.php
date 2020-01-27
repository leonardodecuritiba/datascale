<?php

namespace App\Models\Requests\Settings;

use App\Traits\VariablesTrait;

class RequestStatus
{
	const _STATUS_AGUARDANDO_ = 1;
	const _STATUS_ACEITA_ = 2;
	const _STATUS_NEGADA_ = 3;
	use VariablesTrait;
	const _NAME_ = 'request_status';
}
