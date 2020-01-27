<?php

namespace App\Traits;

use App\Helpers\DataHelper;
use App\Models\Parts\Settings\Cfop;
use App\Models\Parts\Settings\Cst;
use App\Models\Parts\Settings\NatureOperation;
use App\Models\Parts\Settings\Unity;

trait TaxationPartTrait {
	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function valor_bruto_float($qtd)
	{
		return $qtd * $this->attributes['custo_final'];
	}

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

	public function getUnityTextAttribute()
	{
		return Unity::whereId( $this->getAttribute('unity_id'))->code;
	}

	public function getCfopTextAttribute()
	{
        return Cfop::whereId( $this->getAttribute('cfop_id'))->code;
	}

	public function getCstTextAttribute()
	{
        return Cst::whereId( $this->getAttribute('cst_id'))->code;
	}

	public function getNatureOperationTextAttribute()
	{
        return NatureOperation::whereId( $this->getAttribute('nature_operation'))->descriptions;
	}


	public function getIcmsBaseCalculoFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('icms_base_calculo'));
	}

	public function getIcmsValorTotalFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('icms_valor_total'));
	}

	public function getIcmsBaseCalculoStFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('icms_base_calculo_st'));
	}

	public function getIcmsValorTotalStFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('icms_valor_total_st'));
	}


	public function getValorUnitarioComercialFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('valor_unitario_comercial'));
	}

	public function getUnidadeTributavelFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('unidade_tributavel'));
	}

	public function getValorUnitarioTributavelFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('valor_unitario_tributavel'));
	}


	public function getValorIpiFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('valor_ipi'));
	}

	public function getValorFreteFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('valor_frete'));
	}

	public function getValorSeguroFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('valor_seguro'));
	}

	public function getValorTotalFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('valor_total'));
	}


	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

	public function setIcmsBaseCalculoAttribute($value)
	{
		$this->attributes['icms_base_calculo'] = DataHelper::getReal2Float($value);
	}

	public function setIcmsValorTotalAttribute($value)
	{
		$this->attributes['icms_valor_total'] = DataHelper::getReal2Float($value);
	}

	public function setIcmsBaseCalculoStAttribute($value)
	{
		$this->attributes['icms_base_calculo_st'] = DataHelper::getReal2Float($value);
	}

	public function setIcmsValorTotalStAttribute($value)
	{
		$this->attributes['icms_valor_total_st'] = DataHelper::getReal2Float($value);
	}


	public function setValorUnitarioComercialAttribute($value)
	{
		$this->attributes['valor_unitario_comercial'] = DataHelper::getReal2Float($value);
	}

	public function setUnidadeTributavelAttribute($value)
	{
		$this->attributes['unidade_tributavel'] = DataHelper::getReal2Float($value);
	}

	public function setValorUnitarioTributavelAttribute($value)
	{
		$this->attributes['valor_unitario_tributavel'] = DataHelper::getReal2Float($value);
	}


	public function setValorIpiAttribute($value)
	{
		$this->attributes['valor_ipi'] = DataHelper::getReal2Float($value);
	}

	public function setValorFreteAttribute($value)
	{
		$this->attributes['valor_frete'] = DataHelper::getReal2Float($value);
	}

	public function setValorSeguroAttribute($value)
	{
		$this->attributes['valor_seguro'] = DataHelper::getReal2Float($value);
	}

	public function setValorTotalAttribute($value)
	{
		$this->attributes['valor_total'] = DataHelper::getReal2Float($value);
	}

}