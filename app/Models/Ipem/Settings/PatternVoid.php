<?php

namespace App\Models\Ipem\Settings;

use App\Models\Commons\Voidx;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatternVoid extends Model {
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;

	public $timestamps = true;
	protected $fillable = [
		'pattern_id',
		'void_id',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	static public function set( $pattern_id, $void_id ) {
		Voidx::setUsed( $void_id );

		return PatternVoid::create( [
			'pattern_id' => $pattern_id,
			'void_id'    => $void_id,
		] );
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================
	//======================== BELONGSTO =========================
	public function pattern() {
		return $this->belongsTo( Pattern::class, 'pattern_id' );
	}

	public function voidx() {
		return $this->belongsTo( Voidx::class, 'void_id' );
	}

}
