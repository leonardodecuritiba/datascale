<?php

namespace App\Models\Transactions\Settings;

use App\Models\Parts\Service;
use App\Traits\ApparatuValuesTrait;
use App\Traits\OrderValuesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApparatuService extends Model
{
	use SoftDeletes;
	use ApparatuValuesTrait;
	public $timestamps = true;
	protected $fillable = [
		'apparatu_id',
		'service_id',
		'value',
		'quantity',
		'discount',

		'idservico_prestado',
	];

	protected $appends = [
		'parent_name',
		'value_formatted',
		'discount_formatted',
		'total',
		'total_formatted',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function getParentNameAttribute()
	{
		return $this->service->getName();
	}

//	public function valor_original()
//	{
//		return $this->service->custo_final;
//	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
	//======================== BELONGS ===========================
	public function service()
	{
		return $this->belongsTo(Service::class, 'service_id');
	}
}
