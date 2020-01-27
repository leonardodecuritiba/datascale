<?php

namespace App\Models\Commons;

use App\Traits\Configurations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CepCities extends Model {
	use SoftDeletes;
	public $timestamps = true;
	protected $fillable = [
		'state_id',
		'name'
	];

	static public function getAlltoSelectList( array $fields = [ 'id', 'name' ], $api = false ) {
		$result = self::get()->map( function ( $s ) use ( $fields ) {
			return [
				'id'          => $s->{$fields[0]},
				'description' => $s->{$fields[1]}
			];
		} );
		return ($api) ? $result : $result->pluck( 'description', 'id' );
	}

	public function getShortStateName() {
		return $this->state->getShortName();
	}

	public function getShortName() {
		return $this->getAttribute( 'name' );
	}

	static public function findOrFailByStateId( $state_id ) {
		return self::where('state_id',$state_id)->get();
	}

	public function state() {
		return $this->belongsTo( CepStates::class, 'state_id' );
	}
}
