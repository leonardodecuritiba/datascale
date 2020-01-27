<?php

namespace App\Models\Parts\Settings;

use App\Models\Inputs\Equipment;
use App\Models\Parts\Part;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;
	protected $fillable = [
		'description',
		'active',

		'idmarca',
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
        return $this->hasMany(Part::class, 'brand_id');
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'brand_id');
    }

	// ******************** RELASHIONSHIP ******************************
	// ********************** BELONGS ********************************
//	public function instrumento_modelo()
//	{
//		return $this->belongsTo('App\Models\InstrumentoModelo', 'idmarca');
//	}
	// ************************** HASMANY **********************************
}
