<?php

namespace App\Models\Parts;

use App\Models\HumanResources\Client;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;

	protected $fillable = [
		'name',
		'description',

		'idtabela_preco',
	];

	protected $appends = [
		'created_at_time','created_at_formatted',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getName()
	{
		return $this->getAttribute('description');
	}

	public function getContent()
	{
		return $this->getAttribute('description');
	}

	public function getShortDescriptions()
	{
		return $this->getAttribute('description');
	}

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

	//======================== BELONGS ===========================

	//======================== HASMANY ===========================

	public function part_prices()
	{
		return $this->hasMany(PartPrice::class, 'price_id');
	}

	public function service_prices()
	{
		return $this->hasMany(ServicePrice::class, 'price_id');
	}

	public function commercial_clients()
	{
		return $this->hasMany(Client::class, 'commercial_price_id');
	}

	public function technical_clients()
	{
		return $this->hasMany(Client::class, 'technical_price_id');
	}

}
