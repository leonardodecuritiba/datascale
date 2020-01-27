<?php

namespace App\Traits;

use App\Helpers\DataHelper;

trait PriceTrait {
	//============================================================
	//======================== ACCESSORS =========================
	//============================================================
	public function getDataJson()
	{
//		return $this;
		return json_encode($this->only(
			['id','price','price_min','range','range_min',
                'original_price','original_price_formatted',
                'price_formatted','price_min_formatted','range_formatted','range_min_formatted']
		));
	}

    public function getOriginalPriceAttribute()
    {
		return $this->getParent()->value;
    }

    public function getOriginalPriceFormattedAttribute()
    {
        return DataHelper::getFloat2Currency($this->original_price);
    }

	public function getPriceFormattedAttribute()
	{
		return DataHelper::getFloat2Currency($this->getAttribute('price'));
	}

	public function getPriceMinFormattedAttribute()
	{
		return DataHelper::getFloat2Currency($this->getAttribute('price_min'));
	}


	public function getRangeFormattedAttribute()
	{
		return DataHelper::getFloat2Percent($this->getAttribute('range'));
	}

	public function getRangeMinFormattedAttribute()
	{
		return DataHelper::getFloat2Percent($this->getAttribute('range_min'));
	}

	public function getPriceFieldAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('price'));
	}

	public function getPriceMinFieldAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('price_min'));
	}


	public function getRangeFieldAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('range'));
	}

	public function getRangeMinFieldAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('range_min'));
	}

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

	public function setPriceAttribute($value)
	{
		$this->attributes['price'] = DataHelper::getReal2Float($value);
	}

	public function setPriceMinAttribute($value)
	{
		$this->attributes['price_min'] = DataHelper::getReal2Float($value);
	}

	public function setRangeAttribute($value)
	{
		$this->attributes['range'] = DataHelper::getReal2Float($value);
	}

	public function setRangeMinAttribute($value)
	{
		$this->attributes['range_min'] = DataHelper::getReal2Float($value);
	}

	//============================================================
	//======================== SCOPES ============================
	//============================================================


	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================

	//======================== BELONGS ===========================
	public function price_table()
	{
		return $this->belongsTo(Price::class, 'price_id');
	}

}