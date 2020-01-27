<?php

namespace App\Models\Ipem;

use App\Models\Commons\Picture;
use App\Models\Inputs\Instruments\Instrument;
use App\Models\Inputs\Instruments\InstrumentModel;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\Relashionships\PictureTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pam extends Model {
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
	use PictureTrait;
    public $timestamps = true;
    protected $table = 'pams';
	static public $img_path = 'pams';
    protected $fillable = [

        'idinstrumento_base',

        'instrument_model_id',
        'picture_id',
        'description',
        'division',
        'ordinance',
        'capacity',
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


    /*
        static public function getAlltoSelectList() {
            return self::get()->map( function ( $s ) {
                return [
                    'id'          => $s->id,
                    'description' => $s->getDetalhesBase()
                ];
            } )->pluck( 'description', 'id' );
        }

    */

    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================

	public function getBaseDescription()
	{
		return $this->getBrandModel() . ' - ' .
		       $this->attributes['division'] . ' - ' .
		       $this->attributes['ordinance'] . ' - ' .
		       $this->attributes['capacity'];
	}

	public function getBrandModel()
	{
		return $this->instrument_model->getBrandModel();
	}

    //======================== FUNCTIONS =========================
    //======================== BELONGSTO =========================
    public function instrument_model()
    {
        return $this->belongsTo(InstrumentModel::class, 'instrument_model_id');
    }
    public function picture()
    {
        return $this->belongsTo(Picture::class, 'picture_id');
    }
    //======================== HASMANY ===========================
    public function instruments()
    {
        return $this->hasMany(Instrument::class, 'pam_id');
    }

}
