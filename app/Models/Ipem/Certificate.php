<?php

namespace App\Models\Ipem;

use App\Helpers\DataHelper;
use App\Models\Ipem\Settings\CertificatePattern;
use App\Models\Ipem\Settings\PatternVoid;
use App\Models\Users\User;
use App\Traits\DateTimeTrait;
use App\Traits\Relashionships\FileTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model {
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use FileTrait;
	static public $file_path = 'certificates';
	public $timestamps = true;
	protected $fillable = [
		'manager_id',
		'file_id',

		'number',
		'verified_at',
		'due_at',
	];

	protected $appends = [
		'verified_at_time',
		'verified_at_formatted',
		'due_at_time',
		'due_at_formatted',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getName() {
		return $this->getAttribute( 'number' );
	}

	public function getContent() {
		return $this->getAttribute( 'number' );
	}

	public function attachPattern( array $attributes ) {

		$voids = json_decode( $attributes['voids'] );
		for ( $i = 0; $i < $attributes['quantity']; $i ++ ) {
			$pattern = Pattern::create( $attributes );
			PatternVoid::set( $pattern->id, $voids[ $i ] );
			CertificatePattern::set( $this->id, $pattern->id );
		}

	}

	public function detachPattern( $certificate_pattern_id ) {
		//remover certificate_pattern
		return CertificatePattern::destroy( $certificate_pattern_id );
	}
	//============================================================
	//======================== ASSESSORS =========================
	//============================================================

	public function getVerifiedAtFormattedAttribute() {
		return DataHelper::getPrettyDate( $this->attributes['verified_at'] );
	}

	public function getVerifiedAtTimeAttribute() {
		return strtotime( $this->attributes['verified_at'] );
	}

	public function getDueAtFormattedAttribute() {
		return DataHelper::getPrettyDate( $this->attributes['due_at'] );
	}

	public function getDueAtTimeAttribute() {
		return strtotime( $this->attributes['due_at'] );
	}

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================
	public function setVerifiedAtAttribute( $value ) {
		$this->attributes['verified_at'] = DataHelper::getPrettyToCorrectDate( $value );
	}

	public function setDueAtAttribute( $value ) {
		$this->attributes['due_at'] = DataHelper::getPrettyToCorrectDate( $value );
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================
	//======================== BELONGSTO =========================
	public function manager() {
		return $this->belongsTo( User::class, 'manager_id' );
	}

	//======================== HASMANY ===========================
	public function certificate_patterns() {
		return $this->hasMany( CertificatePattern::class, 'certificate_id' )->with( 'pattern' );
	}

	public function certificate_patterns_list() {
//		dd($this->certificate_patterns->with('model','brand','feature')->map( function ( $s ) {
		return $this->certificate_patterns->map( function ( $s ) {
			return [
				'id'             => $s->id,
				'certificate_id' => $s->certificate_id,
				'name'           => $s->pattern->getName(),
				'model_text'     => $s->pattern->model_text,
				'brand_text'     => $s->pattern->brand_text,
				'feature_text'   => $s->pattern->feature_text,
				'mass_formatted' => $s->pattern->mass_formatted,
				'void_text'      => $s->pattern->void_text,
			];
		} );
	}


}
