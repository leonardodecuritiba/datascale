<?php

namespace App\Models\Commons;

use App\Traits\Configurations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CepStates extends Model {
	use SoftDeletes;
	public $timestamps = true;
	protected $fillable = [
		'name',
		'short_name',
	];


	public function findCityByName( $value ) {
		return $this->cities->where( 'name', strtoupper( trim( $value ) ) )->first();
//		return $this->cities;
//			->where('name', trim($value))->first();
//		->where('name', 'like', '%'.trim($value).'%')->first();

//		return $value;
//		return $this->cities
//			->where('name', 'like', '%'.trim($value).'%');

//		return strtoupper(trim($value));

//		return strtoupper(trim($value));
//		return $this->cities;

//		return $this->cities->where('name','like', '%' . strtoupper(trim($value)) . '%');
		return $this->cities->where( 'like', '%' . strtoupper( trim( $value ) ) . '%' );

		return $this->cities->where( function ( $q2 ) use ( $value ) {
			$q2->whereRaw( 'LOWER(`title`) like ?', array( trim( $value ) ) );
		} );


		return $this->cities
			->whereRaw( "name like '%$value%' collate utf8_general_ci " );
	}

	public function getShortName() {
		return $this->attributes['name'];
	}

	static public function findByUf( $value ) {
		return self::where( 'short_name', trim( $value ) )->first();
	}

	static public function getAlltoSelectList() {
		return self::get()->map( function ( $s ) {
			return [
				'id'          => $s->id,
				'description' => $s->name
			];
		} )->pluck( 'description', 'id' );
	}


	public function cities() {
		return $this->hasMany( CepCities::class, 'state_id' );
	}
}
