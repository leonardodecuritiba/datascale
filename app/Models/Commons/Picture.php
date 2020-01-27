<?php

namespace App\Models\Commons;

use App\Models\HumanResources\Client;
use App\Models\HumanResources\Provider;
use App\Models\Inputs\Equipment;
use App\Models\Ipem\Pam;
use App\Models\Parts\Part;
use App\Traits\Configurations;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class Picture extends Model {
    use SoftDeletes;
	use StringTrait;
	public $timestamps = true;
	protected $fillable = [
		'src',
		'title',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function _delete()
	{
		return $this->delete();
	}

	public function getName()
	{
		return $this->getAttribute('title');
	}

	public function getContent()
	{
		return $this->getAttribute('title');
	}
	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
	public function part()
	{
		return $this->hasOne( Part::class, 'picture_id' );
	}

	public function pam()
	{
		return $this->hasOne( Pam::class, 'picture_id' );
	}

	public function equipment()
	{
		return $this->hasOne( Equipment::class, 'picture_id' );
	}

	public function client()
	{
		return $this->hasOne( Client::class, 'picture_id' );
	}

	public function provider()
	{
		return $this->hasOne( Provider::class, 'picture_id' );
	}
}
