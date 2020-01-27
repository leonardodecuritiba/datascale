<?php

namespace App\Models\HumanResources\Settings;

use App\Helpers\DataHelper;
use App\Models\HumanResources\Client;
use App\Models\HumanResources\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalPerson extends Model
{
	use SoftDeletes;
	public $timestamps = true;
	protected $fillable = [
		'cnpj',
		'ie',
		'exemption_ie',
		'social_reason',
		'fantasy_name',
		'ativ_economica',
		'sit_cad_vigente',
		'sit_cad_status',
		'data_sit_cad',
		'reg_apuracao',
		'data_credenciamento',
		'ind_obrigatoriedade',
		'data_ini_obrigatoriedade'
	];

	protected $appends = [
        'cnpj_formatted',
        'ie_formatted',
	];


	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

	public function getIeFormattedAttribute()
	{
		return DataHelper::mask( $this->attributes['ie'], '###.###.###.###' );
	}

	public function getCnpjFormattedAttribute() {
		return DataHelper::mask( $this->attributes['cnpj'], '##.###.###/####-##' );
	}

	public function getDataSitCadAttribute()
	{
		return DataHelper::getPrettyDate($this->attributes['data_sit_cad']);
	}

	public function getDataCredenciamentoAttribute()
	{
		return DataHelper::getPrettyDate($this->attributes['data_credenciamento']);
	}

	public function getDataIniObrigatoriedadeAttribute()
	{
		return DataHelper::getPrettyDate($this->attributes['data_ini_obrigatoriedade']);
	}

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

	public function setIeAttribute( $value ) {
		return $this->attributes['ie'] = DataHelper::getOnlyNumbers( $value );
	}

	public function setExemptionIeAttribute( $value ) {
		return $this->attributes['exemption_ie'] = ($value == 'on' || $value == 1);
	}

	public function setCnpjAttribute( $value ) {
		return $this->attributes['cnpj'] = DataHelper::getOnlyNumbers( $value );
	}

	public function setDataSitCadAttribute($value)
	{
		$this->attributes['data_sit_cad'] = DataHelper::getPrettyToCorrectDate($value);
	}

	public function setDataCredenciamentoAttribute($value)
	{
		$this->attributes['data_credenciamento'] = DataHelper::getPrettyToCorrectDate($value);
	}

	public function setDataIniObrigatoriedadeAttribute($value)
	{
		$this->attributes['data_ini_obrigatoriedade'] = DataHelper::getPrettyToCorrectDate($value);
	}

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	// ********************** HAS ONE ********************************
	public function provider()
	{
		return $this->hasOne( Provider::class, 'legal_person_id' );
	}
	public function client()
	{
		return $this->hasOne( Client::class, 'legal_person_id' );
	}
}
