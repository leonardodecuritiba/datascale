<?php

namespace App\Traits;


use App\Helpers\DataHelper;
use App\Models\Transactions\Apparatu;

trait ApparatuValuesTrait {

    public function getValueFormattedAttribute()
    {
    	return DataHelper::getFloat2Currency($this->getAttribute('value'));
    }

    public function getDiscountFormattedAttribute()
    {
    	return DataHelper::getFloat2Currency($this->getAttribute('discount'));
    }

    public function getTotalAttribute()
    {
	    return ($this->getAttribute('value') * $this->getAttribute('quantity')) - $this->getAttribute('discount');
    }

    public function getTotalFormattedAttribute()
    {
    	return DataHelper::getFloat2Currency($this->total);
    }

	public function apparatu()
	{
		return $this->belongsTo(Apparatu::class, 'apparatu_id');
	}

}