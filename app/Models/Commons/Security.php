<?php

namespace App\Models\Commons;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Security extends Model {
	public $timestamps = true;
	protected $fillable = [
		'creator_id',
		'validator_id',
		'verb',
		'table',
		'pk',
		'validated_at',
	];
	protected $dates = [
		'validated_at',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	static public function onCreate(array $attributes){
		$attributes['creator_id'] = Auth::id();
		$attributes['verb'] = 'CREATE';
		return parent::create($attributes);
	}

	static public function onUpdate(array $attributes){
		$attributes['creator_id'] = Auth::id();
		$attributes['verb'] = 'UPDATE';
		return parent::create($attributes);
	}

	static public function onDelete(array $attributes){
		$attributes['creator_id'] = Auth::id();
		$attributes['verb'] = 'DELETE';
		return parent::create($attributes);
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
	public function creator() {
		return $this->belongsTo( User::class, 'creator_id' );
	}
	public function validator() {
		return $this->belongsTo( User::class, 'validator_id' );
	}
}
