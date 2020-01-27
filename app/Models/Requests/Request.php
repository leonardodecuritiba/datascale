<?php

namespace App\Models\Requests;

use App\Models\Transactions\Settings\ApparatuService;
use App\Models\Users\User;
use App\Traits\DateTimeTrait;
use App\Traits\Requests\RequestFlowTrait;
use App\Traits\Requests\RequestStatusTrait;
use App\Traits\Requests\RequestTypeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use RequestStatusTrait;
	use RequestTypeTrait;
	use RequestFlowTrait;
	use StringTrait;
	public $timestamps = true;

	protected $fillable = [
		'type',
		'status',
		'requester_id',
		'manager_id',
		'reason',
		'parameters',
		'response',
		'end_at',
	];

	protected $appends = [
		'created_at_time','created_at_formatted',
		'end_at_time','end_at_formatted',

		'response_text',
		'type_text',

		'status_text',
		'status_color',
		'status_icon',

	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function getName()
	{
		return $this->getAttribute('name');
	}

	public function getContent()
	{
		return $this->getAttribute('description');
	}

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================


//	public function getFormatedRequest()
//	{
//		return json_encode([
//			'id'                => $this->getAttribute('id'),
//			'date'              => $this->created_at,
//			'type'              => $this->getTypeText(),
//			'parameters'        => $this->getParametersText(),
//			'parameters_json'   => $this->getAttribute('parameters'),
//			'reason'            => $this->getAttribute('reason'),
//			'status'            => $this->getStatusText(),
//			'manager'           => $this->getNameManager(),
//			'requester'         => $this->getNameRequester(),
//		]);
//	}


	public function getParametersDecoded()
	{
		return json_decode($this->getAttribute('parameters'));
	}

	public function getNameManager()
	{
		return optional($this->manager)->getName();
	}

	public function getRequesterName()
	{
		return $this->requester->getName();
	}

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================


	//============================================================
	//======================== SCOPES ============================
	//============================================================


	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
	//======================== FUNCTIONS =========================


	//======================== BELONGS ===========================
//	public function status()
//	{
//		return $this->belongsTo(RequestStatus::class, 'status');
//	}
//
//	public function type()
//	{
//		return $this->belongsTo(RequestType::class, 'type');
//	}

	public function requester()
	{
		return $this->belongsTo(User::class, 'requester_id');
	}

	public function manager()
	{
		return $this->belongsTo(User::class, 'manager_id');
	}

	//======================== HASMANY ===========================



}
