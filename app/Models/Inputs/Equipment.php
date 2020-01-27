<?php

namespace App\Models\Inputs;

use App\Models\Commons\Picture;
use App\Models\HumanResources\Client;
use App\Models\Parts\Settings\Brand;
use App\Models\Transactions\Apparatu;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\Relashionships\PictureTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model {
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
	use PictureTrait;
    public $timestamps = true;
    protected $table = 'equipments';

	static public $img_path = 'equipments';

	protected $fillable = [
        'client_id',
        'brand_id',
        'picture_id',
        'description',
        'model',
        'serial_number',
        'active',

        'idequipamento'
    ];


	protected $appends = [
        'image',
        'thumb_image',
    ];


    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================

    public function getBrandName() {
        return $this->brand->getName();
    }

    //======================== FUNCTIONS =========================
    public function has_apparatus()
    {
        return ($this->apparatus()->count() > 0);
    }

    public function getName(){
        return $this->description;
    }

    //======================== BELONGS ===========================

    public function client()
    {
        return $this->belongsTo( Client::class, 'client_id' );
    }

    public function brand()
    {
        return $this->belongsTo( Brand::class, 'brand_id' );
    }

    public function picture()
    {
        return $this->belongsTo(Picture::class, 'picture_id');
    }
	//======================== HASMANY =========================

	public function apparatus()
    {
		return $this->hasMany( Apparatu::class, 'equipment_id' );
	}
}
