<?php

namespace App\Models\Financials;

use App\Helpers\DataHelper;
use App\Models\Financials\Settings\PortionStatus;
use App\Traits\Billings\PaymentFormTrait;
use App\Traits\Billings\PortionFlowTrait;
use App\Traits\Billings\PortionStatusTrait;
use App\Traits\DateTimeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portion extends Model
{
	use SoftDeletes;
	use PortionStatusTrait;
	use PortionFlowTrait;
	use PaymentFormTrait;
	use DateTimeTrait;
	public $timestamps = true;

	protected $fillable = [
		'payment_id',
		'status',
		'payment_form',
		'due_at',
		'paid_at',
		'setted_at',
		'portion_number',
		'portion_value',
	];

	protected $appends = [
		'created_at_time','created_at_formatted','created_at_full_formatted',
		'due_at_time','due_at_formatted',
		'paid_at_time','paid_at_formatted',
		'setted_at_time','setted_at_formatted',

		'payment_form_text',
		'portion_value_formatted',

		'status_icon',
		'status_color',
		'status_text',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function getPortionNumberText()
	{
		return $this->getAttribute('portion_number') . '/' . $this->payment->portions->count();
	}


	public function getPortionValueFormattedAttribute()
	{
		return DataHelper::getFloat2Currency($this->getAttribute('portion_value'));
	}

	static public function setPortions($data, $data_portions)
	{
		//CRIAR PARCELAS, ATRIBUIR ID PAGAMENTO A ELAS
		for ($i = 0; $i < $data_portions['quantity']; $i++) {
            $due = Carbon::now()->addDay($data_portions['due'][$i]);
			self::create([
				'payment_id'        => $data['payment_id'],
				'status'            => PortionStatus::_STATUS_ABERTO_,
				'payment_form'      => $data['payment_form'],
				'due_at'            => $due->format('Y-m-d'),
				'portion_number'    => $i + 1,
				'portion_value'     => $data['portion_value']
			]);
		}
		return true;
	}

//	/**
//	 * Scope a query to only include active users.
//	 *
//	 * @param \Illuminate\Database\Eloquent\Builder $query
//	 * @return \Illuminate\Database\Eloquent\Builder
//	 */
//	public function scopeSumRealValorParcela($query)
//	{
//		return DataHelper::getFloat2RealMoeda($query->sum('valor_parcela'));
//	}
//
//
//
//	static public function getAreceber($ndays)
//	{
//		return self::pendentes()
//		           ->where('data_vencimento', '<=', Carbon::now()
//		                                                  ->addDays($ndays)
//		                                                  ->format('Y-m-d'))
//		           ->SumRealValorParcela();
//	}
//
//
//
//	// ********************** Accessors ********************************
//	public function setDataPagamentoAttribute($value)
//	{
//		return $this->attributes['data_pagamento'] = DataHelper::setDate($value);
//	}

//	// ********************** BELONGS ********************************

	public function payment()
	{
		return $this->belongsTo(Payment::class, 'payment_id');
	}

//	public function billing()
//	{
//		return $this->payment->billing();
//	}
//
//	public function client()
//	{
//		return $this->billing->client();
//	}

//	// ************************** HASMANY **********************************

}
