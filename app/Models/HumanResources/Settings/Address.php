<?php

namespace App\Models\HumanResources\Settings;

use App\Models\Commons\CepCities;
use App\Models\Commons\CepStates;
use App\Models\HumanResources\Client;
use App\Models\HumanResources\Provider;
use App\Traits\AddressTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {
	use SoftDeletes;
	use AddressTrait;
	public $timestamps = true;
	protected $fillable = [
		'state_id',
		'city_id',
		'city_code',
		'zip',
		'district',
		'street',
		'number',
		'complement'
	];

	protected $with = array( 'state', 'city' );

	protected $appends = [
		'zip_formatted',
		'city_name',
		'uf_name',
		'city_uf'
	];

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================


    //============================================================
    //======================== RELASHIONSHIPS ====================
    //============================================================
	// ********************  ******************************

	public function state() {
		return $this->belongsTo( CepStates::class, 'state_id' );
	}

	public function city() {
		return $this->belongsTo( CepCities::class, 'city_id', 'id' );
	}

	public function provider() {
		return $this->hasOne( Provider::class, 'address_id' );
	}

	public function client() {
		return $this->hasOne( Client::class, 'address_id' );
	}

}
