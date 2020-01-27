<?php

namespace App\Models\Parts;

use App\Traits\DateTimeTrait;
use App\Traits\PriceTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePrice extends Model
{
	use SoftDeletes;
	use PriceTrait;
	use DateTimeTrait;
	public $timestamps = true;

	protected $fillable = [
		'price_id',
		'service_id',
		'price',
		'price_min',
		'range',
		'range_min',
	];

	protected $appends = [
		'created_at_time','created_at_formatted',

        'original_price',
        'original_price_formatted',
		'price_formatted',
		'price_min_formatted',
		'range_formatted',
		'range_min_formatted',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

	//============================================================
	//======================== SCOPES ============================
	//============================================================


	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================
	public function getServiceName()
	{
		return optional($this->service)->getName();
	}

	public function getPriceTableName()
	{
		return optional($this->price_table)->getName();
	}
	
    public function getParent()
    {
        return $this->service;
    }

//	public function getServicePrice()
//	{
//		$val = optional($this->service)->value_formatted;
//		return !is_null($val) ? 'R$ ' . $val : '';
//	}

	//======================== BELONGS ===========================

	public function price_table()
	{
		return $this->belongsTo(Price::class, 'price_id');
	}

	public function service()
	{
		return $this->belongsTo(Service::class, 'service_id');
	}

	//======================== HASMANY ===========================


}
