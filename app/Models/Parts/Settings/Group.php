<?php

namespace App\Models\Parts\Settings;

use App\Models\Parts\Part;
use App\Models\Parts\Service;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;
	protected $fillable = [
		'description',
		'active',

		'idgrupo',
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

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
	public function parts()
	{
		return $this->hasMany(Part::class, 'group_id');
	}

	public function services()
	{
		return $this->hasMany(Service::class, 'group_id');
	}
}
