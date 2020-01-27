<?php

namespace App\Models\Commons;

use App\Models\Ipem\Settings\PatternVoid;
use App\Traits\SealLabelTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voidx extends Model {
	use SealLabelTrait;
	use SoftDeletes;
	use StringTrait;
	public $timestamps = true;
	protected $table = 'voids';
	protected $fillable = [
		'owner_id',
		'number',
		'used',
	];

	protected $appends = [
		'number_formatted',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getNumberFormattedAttribute() {
		return $this->getAttribute( 'number' );
	}

	public function getName() {
		return $this->getAttribute('number');
	}

	public function getContent() {
		return $this->getAttribute('number');
	}

	/**
	 * Scope a query to only include active.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive( $query ) {
		return $query->where( 'used', 0 );
	}
	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== HASONE ============================
	public function pattern_void() {
		return $this->hasOne( PatternVoid::class, 'void_id' );
	}

}
