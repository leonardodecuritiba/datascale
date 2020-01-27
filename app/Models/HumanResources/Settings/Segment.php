<?php

namespace App\Models\HumanResources\Settings;

use App\Models\HumanResources\Client;
use App\Models\HumanResources\Provider;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;
	protected $fillable = [
		'description',
		'active',

		'idsegmento',
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
	// ************************** HASMANY **********************************
    public function providers()
    {
        return $this->hasMany(Provider::class, 'segment_id');
    }

	public function clients()
	{
		return $this->hasMany( Client::class, 'segment_id' );
	}

}
