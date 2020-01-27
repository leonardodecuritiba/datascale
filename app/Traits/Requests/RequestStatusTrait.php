<?php

namespace App\Traits\Requests;

use App\Models\Requests\Settings\RequestStatus;

trait RequestStatusTrait {


	public function isWaiting()
	{
		return ( $this->getAttribute( 'status' ) == RequestStatus::_STATUS_AGUARDANDO_ );
	}

	public function getStatusColorAttribute()
	{
		switch ($this->getAttribute('status')) {
			case RequestStatus::_STATUS_AGUARDANDO_:
				return 'warning';
			case RequestStatus::_STATUS_ACEITA_:
				return 'success';
			case RequestStatus::_STATUS_NEGADA_:
				return 'danger';
		}
	}

	public function getStatusIconAttribute()
	{
		switch ($this->getAttribute('status')){
			case RequestStatus::_STATUS_AGUARDANDO_:
				return 'autorenew';
			case RequestStatus::_STATUS_ACEITA_:
				return 'done';
			case RequestStatus::_STATUS_NEGADA_:
				return 'report_problem';
		}
	}

	public function getStatusTextAttribute()
	{
		return RequestStatus::whereId( $this->getAttribute( 'status' ) )->description;
	}

	public function canShowDenyBtn()
	{
		return ( $this->getAttribute( 'status' ) == RequestStatus::_STATUS_AGUARDANDO_ );
	}

	public function canShowAceptBtn()
	{
		return ( $this->getAttribute( 'status' ) == RequestStatus::_STATUS_AGUARDANDO_ );
	}

	public function getResponseTextAttribute()
	{
		switch ($this->getAttribute('status')) {
			case RequestStatus::_STATUS_NEGADA_:
				return 'Motivo: ' . $this->getAttribute('response');
			case RequestStatus::_STATUS_ACEITA_:
				return '-';
				break;
		}
	}

	/*
	 * ========================================================
	 * SCOPE ==================================================
	 * ========================================================
	 */

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeWaiting($query)
	{
		return $query->where( 'status', RequestStatus::_STATUS_AGUARDANDO_ );
	}

}