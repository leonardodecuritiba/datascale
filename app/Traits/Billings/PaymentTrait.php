<?php

namespace App\Traits\Billings;

use App\Helpers\DataHelper;
use App\Models\Financials\Payment;

trait PaymentTrait {

	//============================================================
	//======================== STATUS ============================
	//============================================================

	public function getPaymentStatus() //getPagoStatus
	{
		return ($this->payment->status);
	}

	public function getPaymentStatusIcon() //getPagoStatusColor
	{
		return ($this->payment->status) ? 'check' : 'time';
	}

	public function getPaymentStatusColor() //getPagoStatusColor
	{
		return ($this->payment->status) ? 'success' : 'danger';
	}

	public function getPaymentStatusText() //getPagoText
	{
		return ($this->payment->status) ? 'QUITADO' : 'PAGAMENTO PENDENTE';
	}


	//============================================================
	//======================== FLOW ==============================
	//============================================================

    public function getTotalPendentFormatted()
    {
        return DataHelper::getFloat2Currency($this->getTotalPendent());
    }

    public function getTotalPendent()
    {
        return $this->payment->pendent_portions()->sum('portion_value');
    }

    public function getTotalReceivedFormatted()
    {
        return DataHelper::getFloat2Currency($this->getTotalReceived());
    }

    public function getTotalReceived()
    {
        return $this->payment->received_portions()->sum('portion_value');
    }

	//======================== BELONGS ===========================
	public function payment()
	{
		return $this->belongsTo(Payment::class, 'payment_id');
	}



}