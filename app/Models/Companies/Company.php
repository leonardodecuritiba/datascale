<?php

namespace App\Companies;

use App\Traits\DateTimeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	public $timestamps = true;
	protected $fillable = [
		'franchise'
	];

}
