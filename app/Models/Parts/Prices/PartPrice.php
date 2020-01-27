<?php

namespace App\Models\Parts;

use App\Traits\DateTimeTrait;
use App\Traits\PriceTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartPrice extends Model
{
	use SoftDeletes;
	use PriceTrait;
	use DateTimeTrait;
	public $timestamps = true;

	protected $fillable = [
		'price_id',
		'part_id',
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
		'price_field',
		'price_min_field',
		'range_field',
		'range_min_field',
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
	public function getPartName()
	{
		return optional($this->part)->getName();
	}

    public function getPriceTableName()
    {
	    return optional($this->price_table)->getName();
    }

    public function getParent()
    {
        return $this->part;
    }

//	public function getPartPrice()
//	{
//		$val = optional($this->part)->valor_total_formatted;
//		return !is_null($val) ? 'R$ ' . $val : '';
//	}

	//======================== BELONGS ===========================

	public function price_table()
	{
		return $this->belongsTo(Price::class, 'price_id');
	}

	public function part()
	{
		return $this->belongsTo(Part::class, 'part_id');
	}

	//======================== HASMANY ===========================


}
