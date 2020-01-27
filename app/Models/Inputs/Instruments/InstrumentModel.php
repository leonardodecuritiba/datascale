<?php

namespace App\Models\Inputs\Instruments;

use App\Models\Ipem\Pam;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstrumentModel extends Model {
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    public $timestamps = true;
    protected $fillable = [

        'idinstrumento_modelo',

        'instrument_brand_id',
        'description',
        'active',
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

	public function getBrandModel()
	{
		return $this->instrument_brand->getName() . ' / ' . $this->getName();
	}

    //============================================================
    //======================== BELONGSTO =========================
    public function instrument_brand()
    {
        return $this->belongsTo(InstrumentBrand::class, 'instrument_brand_id');
    }
    //======================== HASMANY ===========================
    public function pams()
    {
        return $this->hasMany(Pam::class, 'instrument_model_id');
    }
}
