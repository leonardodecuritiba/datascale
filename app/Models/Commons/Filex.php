<?php

namespace App\Models\Commons;

use App\Models\Ipem\Certificate;
use App\Traits\Configurations;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filex extends Model {
	use SoftDeletes;
	use StringTrait;
	public $timestamps = true;
	protected $table = 'files';
	protected $fillable = [
		'src',
		'title',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function _delete() {
		return $this->delete();
	}

	public function getName() {
		return $this->getAttribute( 'title' );
	}

	public function getContent() {
		return $this->getAttribute( 'title' );
	}
	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
	public function certificate() {
		return $this->hasOne( Certificate::class, 'file_id' );
	}
}
