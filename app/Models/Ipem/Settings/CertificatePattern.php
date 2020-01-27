<?php

namespace App\Models\Ipem\Settings;

use App\Models\Ipem\Pattern;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificatePattern extends Model {
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;
	protected $fillable = [
		'certificate_id',
		'pattern_id'
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	static public function set( $certificate_id, $pattern_id ) {
		return CertificatePattern::create( [
			'certificate_id' => $certificate_id,
			'pattern_id'     => $pattern_id,
		] );
	}


	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================
	//======================== BELONGSTO =========================
	public function certificate() {
		return $this->belongsTo( Certificate::class, 'certificate_id' );
	}

	public function pattern() {
		return $this->belongsTo( Pattern::class, 'pattern_id' );
	}

}
