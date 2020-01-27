<?php

namespace App\Models\Requests;

use App\Helpers\DataHelper;
use App\Models\Requests\Settings\RequestPatternItem;
use App\Models\Requests\Settings\RequestPatternType;
use App\Models\Users\User;
use App\Traits\DateTimeTrait;
use App\Traits\Requests\RequestStatusTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestPattern extends Model {
	use SoftDeletes;
	use DateTimeTrait;
	use RequestStatusTrait;
	use StringTrait;
	public $timestamps = true;
	protected $fillable = [
		'requester_id',
		'manager_id',

		'number',
		'status',
		'type',
		'value',
		'reason',
		'response',
		'denied_at',
		'accepted_at',
	];

	protected $appends = [
		'response_text',
		'type_text',

		'status_text',
		'status_color',
		'status_icon',

		'value_formatted',
		'denied_at_formatted',
		'accepted_at_formatted',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getTotal() {
		$mass = $this->itens->sum( function ( $s ) {
			return $s->pattern->mass;
		} );

		return ( $mass > 0 ) ? DataHelper::getFloat2Real( $mass / 1000 ) . 'Kg' : '-';
	}

	public function getName() {
		return $this->getAttribute( 'requester_id' );
	}

	public function getContent() {
		return $this->getAttribute( 'requester_id' );
	}

	public function getRequesterName() {
		return $this->requester->getName();
	}

	public function getManagerName() {
		return $this->manager->getName();
	}

	public function getTypeTextAttribute() {
		return RequestPatternType::whereId( $this->getAttribute( 'type' ) )->description;
	}

    public function attachPattern( array $attributes ) {
        return RequestPatternItem::create( [
            'request_pattern_id'    => $this->id,
            'pattern_id'            => $attributes['pattern_id'],

        ] );
    }

    public function detachPattern( $request_pattern_id ) {
        //remover certificate_pattern
        return RequestPatternItem::destroy( $request_pattern_id );
    }

	//============================================================
	//======================== ASSESSORS =========================
	//============================================================

	public function getDeniedAtFormattedAttribute() {
		return DataHelper::getPrettyDate( $this->attributes['denied_at'] );
	}

	public function getAcceptedAtFormattedAttribute() {
		return DataHelper::getPrettyDate( $this->attributes['accepted_at'] );
	}

	public function getValueFormattedAttribute() {
		return DataHelper::getFloat2Currency( $this->attributes['value'] );
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================
	//======================== BELONGSTO =========================
	public function requester() {
		return $this->belongsTo( User::class, 'requester_id' );
	}

	public function manager() {
		return $this->belongsTo( User::class, 'manager_id' );
	}

	//======================== HASMANY ===========================
	public function itens() {
		return $this->hasMany( RequestPatternItem::class, 'request_pattern_id' );
	}


    public function itens_list() {
        return $this->itens->map( function ( $s ) {
            return [
                'id'                    => $s->id,
                'request_pattern_id'    => $s->request_pattern_id,
                'name'                  => $s->pattern->getName(),
                'model_text'            => $s->pattern->model_text,
                'brand_text'            => $s->pattern->brand_text,
                'feature_text'          => $s->pattern->feature_text,
                'mass_formatted'        => $s->pattern->mass_formatted,
                'void_text'             => $s->pattern->void_text,
            ];
        } );
    }
}
