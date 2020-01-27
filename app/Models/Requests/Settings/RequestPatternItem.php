<?php

namespace App\Models\Requests\Settings;

use App\Models\Ipem\Pattern;
use App\Models\Requests\RequestPattern;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestPatternItem extends Model {
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;

	public $table = 'request_pattern_itens';
	public $timestamps = true;
	protected $fillable = [
		'request_pattern_id',
		'pattern_id',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	static public function set( $pattern_id, $void_id ) {
		return RequestPatternItem::create( [
			'pattern_id' => $pattern_id,
			'void_id'    => $void_id,
		] );
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================
	//======================== BELONGSTO =========================

	public function request_pattern() {
		return $this->belongsTo( RequestPattern::class, 'request_pattern_id' );
	}

	public function pattern() {
		return $this->belongsTo( Pattern::class, 'pattern_id' );
	}

}
