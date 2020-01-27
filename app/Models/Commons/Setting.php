<?php

namespace App\Models\Commons;

use App\Helpers\DataHelper;
use App\Traits\Configurations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model {
	use SoftDeletes;
	public $timestamps = true;
	protected $fillable = [
		'meta_key',
		'meta_value',
		'field_type',
		'field_class',
	];

	static public function getByMetaKey($value)
	{
		return self::where('meta_key',$value)->first();
	}

	static public function getValueByMetaKey($value)
	{
		return self::getByMetaKey($value)->meta_value;
	}

	public function getCreatedAtAttribute($value)
	{
		return DataHelper::getPrettyDateTime($value);
	}

	public function _increment()
	{
		$this->meta_value += 1;
		$this->save();
		return;
	}
}
