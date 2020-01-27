<?php

namespace App\Traits\Requests;


use App\Models\Inputs\Settings\Label;
use App\Models\Inputs\Settings\Seal;
use App\Models\Requests\Settings\RequestType;

trait RequestTypeTrait {


	public function getTypeTextAttribute()
	{
		return RequestType::whereId($this->getAttribute('type'))->description;
	}

	public function getParametersText()
	{
		$parameters = $this->getParametersDecoded();
		switch ($this->getAttribute('type')) {
			case RequestType::_TYPE_LABELS_:
				if(isset($parameters->quantidade)){
					$qtd = $parameters->quantidade;
				} else {
					$qtd = $parameters->quantity;
				}
				return 'Quantidade: ' . $qtd;
			case RequestType::_TYPE_SEALS_:
				if(isset($parameters->quantidade)){
					$qtd = $parameters->quantidade;
				} else {
					$qtd = $parameters->quantity;
				}
				return 'Quantidade: ' . $qtd;
				break;
//			case RequestType::_TYPE_PECAS_:
//				$p = PartStock::findOrFail($parameters->id);
//				return 'Peça: ' . $p->getShortDescritptions();
//				break;
		}
	}

	public function getParametersValuesTextAttribute()
	{
		$parameters = $this->getParametersDecoded();
		$values = [];
		switch ($this->getAttribute('type')) {
			case RequestType::_TYPE_LABELS_:
				if(isset($parameters->values)){
					$values = $this->getLabels($parameters->values);
				} else if(isset($parameters->valores)){
					$values = $this->getLabels($parameters->valores);
				}
				break;
			case RequestType::_TYPE_SEALS_:
				if(isset($parameters->values)){
					$values = $this->getSeals($parameters->values);
				} else if(isset($parameters->valores)){
					$values = $this->getSeals($parameters->valores);
				}
				break;
		}
		return $values;
	}


	public function getLabels($ids)
	{
		return Label::whereIn('id',$ids)->get()->map(function($s){
			return $s->number_formatted;
		});
	}

	public function getSeals($ids)
	{
		return Seal::whereIn('id',$ids)->get()->map(function($s){
			return $s->number_formatted;
		});
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
	public function scopeLabels($query)
	{
		return $query->where('type', RequestType::_TYPE_LABELS_);
	}
	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeLabelSeals($query)
	{
		return $query->where('type', RequestType::_TYPE_LABELS_)
		             ->orWhere('type', RequestType::_TYPE_SEALS_);
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeSeals($query)
	{
		return $query->where('type', RequestType::_TYPE_SEALS_);
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeTools($query)
	{
		return $query->where('type', RequestType::_TYPE_TOOLS_);
	}

	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopePatterns($query)
	{
		return $query->where('type', RequestType::_TYPE_PATTERNS_);
	}
	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeParts($query)
	{
		return $query->where('type', RequestType::_TYPE_PARTS_);
	}

}