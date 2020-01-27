<?php

namespace App\Traits\Billings;

use Carbon\Carbon;

trait PortionFlowTrait {


	static public function set($data)
	{
		$self = self::findOrFail($data['id']);
		$now = Carbon::now();
		$paid = Carbon::createFromFormat('d/m/Y',$data['paid_at']);
		$due = Carbon::createFromFormat('Y-m-d',$self->due_at);
		$update = [
			'paid_at'   => $paid->format('Y-m-d'),
			'setted_at' => $now->format('Y-m-d'),
			'status'    => $due->diffInDays($paid) > 0 ? PortionStatusTrait::$_STATUS_PAGO_EM_ATRASO_ : PortionStatusTrait::$_STATUS_PAGO_
		];
		switch ($update['status']) {
			case PortionStatusTrait::$_STATUS_ABERTO_ :
			case PortionStatusTrait::$_STATUS_VENCIDO_ :
				$update['paid_at'] = NULL;
				$update['setted_at'] = NULL;
				break;
		}
		$self->update($update);
		return $self;
	}
}