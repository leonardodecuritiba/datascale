<?php

namespace App\Models\Ipem;

use App\Helpers\DataHelper;
use App\Models\Ipem\Settings\CertificatePattern;
use App\Models\Ipem\Settings\PatternBrand;
use App\Models\Ipem\Settings\PatternFeature;
use App\Models\Ipem\Settings\PatternModel;
use App\Models\Ipem\Settings\PatternVoid;
use App\Models\Requests\Settings\RequestPatternItem;
use App\Models\Users\User;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pattern extends Model {
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;
	protected $fillable = [
		'owner_id',

		'model_id',
		'brand_id',
		'feature_id',
		'mass',
	];
	protected $appends = [
		'model_text',
		'brand_text',
		'feature_text',
		'mass_formatted',
		'void_text',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getModelTextAttribute() {
		return PatternModel::whereId( $this->getAttribute( 'model_id' ) )->description;
	}

	public function getBrandTextAttribute() {
		return PatternBrand::whereId( $this->getAttribute( 'brand_id' ) )->description;
	}

	public function getFeatureTextAttribute() {
		return PatternFeature::whereId( $this->getAttribute( 'feature_id' ) )->description;
	}

	public function getMassFormattedAttribute() {
		return DataHelper::getFloat2Real( $this->getAttribute( 'mass' ) / 1000 ) . 'Kg';
	}

	public function getVoidTextAttribute() {
		return $this->pattern_void->voidx->number_formatted;
	}

	public function getName() {
		return "(" . $this->void_text . ") " . $this->mass_formatted . ' - ' . $this->feature_text;
	}

	public function getContent() {
		return $this->getName();
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================

	//======================== HASMANY ===========================
	public function pattern_void() {
		return $this->hasOne( PatternVoid::class, 'pattern_id' );
	}

	public function certificate_pattern() {
		return $this->hasOne( CertificatePattern::class, 'pattern_id' );
	}

	public function request_pattern_item() {
		return $this->hasOne( RequestPatternItem::class, 'pattern_id' );
	}

	//======================== BELONGSTO =========================
	public function owner() {
		return $this->belongsTo(User::class, 'owner_id');
	}


}
