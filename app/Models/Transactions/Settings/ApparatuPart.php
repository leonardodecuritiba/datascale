<?php

namespace App\Models\Transactions\Settings;

use App\Models\Parts\Part;
use App\Traits\ApparatuServicesTrait;
use App\Traits\ApparatuValuesTrait;
use App\Traits\OrderValuesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApparatuPart extends Model
{
    use SoftDeletes;
	use ApparatuValuesTrait;
	public $timestamps = true;
	protected $fillable = [
		'apparatu_id',
		'part_id',
		'value',
		'quantity',
		'discount',

		'idpeca_utilizada',
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
		return $this->part->getName();
	}

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

//	public function valor_original()
//	{
//		return $this->peca->custo_final;
//	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
	//======================== BELONGS ===========================
	public function part()
	{
		return $this->belongsTo(Part::class, 'part_id');
	}
}
