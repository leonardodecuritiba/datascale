<?php

namespace App\Models\Financials\Settings;

use App\Traits\VariablesTrait;

class PortionStatus
{
    const _STATUS_ABERTO_ = 1;
    const _STATUS_PAGO_ = 2;
    const _STATUS_PAGO_EM_ATRASO_ = 3;
    const _STATUS_PAGO_EM_CARTORIO_ = 4;
    const _STATUS_CARTORIO_ = 5;
    const _STATUS_DESCONTADO_ = 6;
    const _STATUS_VENCIDO_ = 7;
    const _STATUS_PROTESTADO_ = 8;
	use VariablesTrait;
	const _NAME_ = 'portion_status';
}
