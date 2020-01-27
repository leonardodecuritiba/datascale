<?php

namespace App\Traits\Billings;


use App\Models\Financials\Settings\PortionStatus;

trait PortionStatusTrait {

    static $_STATUS_ABERTO_ = 1;
    static $_STATUS_PAGO_ = 2;
    static $_STATUS_PAGO_EM_ATRASO_ = 3;
    static $_STATUS_PAGO_EM_CARTORIO_ = 4;
    static $_STATUS_CARTORIO_ = 5;
    static $_STATUS_DESCONTADO_ = 6;
    static $_STATUS_VENCIDO_ = 7;
    static $_STATUS_PROTESTADO_ = 8;


	//============================================================
	//======================== STATUS ============================
	//============================================================

	public function received()
	{
		return (in_array($this->getAttribute('status'), [
			self::$_STATUS_PAGO_,
			self::$_STATUS_PAGO_EM_ATRASO_,
			self::$_STATUS_PAGO_EM_CARTORIO_,
			self::$_STATUS_DESCONTADO_,
			self::$_STATUS_PROTESTADO_,
		]));
	}


	public function getStatusColorAttribute()
	{
		switch ($this->getAttribute('status')){
			case self::$_STATUS_ABERTO_:
				return 'warning';
			case self::$_STATUS_DESCONTADO_:
			case self::$_STATUS_PAGO_EM_ATRASO_:
			case self::$_STATUS_CARTORIO_:
			case self::$_STATUS_PROTESTADO_:
				return 'primary';
			case self::$_STATUS_PAGO_:
				return 'success';
			case self::$_STATUS_VENCIDO_:
				return 'danger';
		}
	}

	public function getStatusIconAttribute()
	{
		switch ($this->getAttribute('status')){
			case self::$_STATUS_ABERTO_:
				return 'info';
			case self::$_STATUS_DESCONTADO_:
			case self::$_STATUS_PAGO_EM_ATRASO_:
			case self::$_STATUS_CARTORIO_:
			case self::$_STATUS_PROTESTADO_:
				return 'compare_arrows';
			case self::$_STATUS_PAGO_:
				return 'done';
			case self::$_STATUS_VENCIDO_:
				return 'times';
		}
	}

	public function getStatusTextAttribute()
	{
		return PortionStatus::whereId($this->getAttribute('status'))->description;
	}

	//============================================================
	//======================== FLOW ==============================
	//============================================================

	//============================================================
	//======================== SCOPES ============================
	//============================================================
	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopePendents($query)
	{
		return $query->whereIn('status', [
			self::$_STATUS_ABERTO_,
			self::$_STATUS_VENCIDO_,
			self::$_STATUS_CARTORIO_,
		]);
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeReceiveds($query)
	{
		return $query->whereIn('status', [
			self::$_STATUS_PAGO_,
			self::$_STATUS_PAGO_EM_ATRASO_,
			self::$_STATUS_PAGO_EM_CARTORIO_,
			self::$_STATUS_DESCONTADO_,
			self::$_STATUS_PROTESTADO_,
		]);
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeRegistry($query)
	{
		return $query->where('status', self::$_STATUS_CARTORIO_);
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeDiscounteds($query)
	{
		return $query->where('status', self::$_STATUS_DESCONTADO_);
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeExpireds($query)
	{
		return $query->where('status', self::$_STATUS_VENCIDO_);
	}

}