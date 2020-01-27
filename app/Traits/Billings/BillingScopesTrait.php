<?php

namespace App\Traits\Billings;


use App\Helpers\DataHelper;
use Illuminate\Support\Collection;

trait BillingScopesTrait {

	//============================================================
	//======================== SCOPES ============================
	//============================================================

	/**
	 * Scope a query to only include popular users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOppened($query)
	{
		return $query->where('status', BillingStatusTrait::$_STATUS_ABERTA_)->orderBy('id');
	}

	/**
	 * Scope a query to only include popular users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeFinalizeds($query)
	{
		return $query->where('status', BillingStatusTrait::$_STATUS_FINALIZADO_)->orderBy('id');
	}

	/**
	 * Scope a query to only include popular users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopePaids($query)
	{
		return $query->where('status', BillingStatusTrait::$_STATUS_QUITADO_)->orderBy('id');
	}

	/**
	 * Scope a query to only include popular users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeLastCreated($query)
	{
		return $query->orderBy('created_at', 'desc')->first();
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeCostCenters($query)
	{
		return $query->where('cost_center', 1);
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeClients($query)
	{
		return $query->where('cost_center', 0);
	}


}