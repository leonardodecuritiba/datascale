<?php

namespace App\Traits;

use App\Helpers\DataHelper;

trait DateTimeTrait {

	public function getCreatedAtTimeAttribute()
	{
		return strtotime( $this->attributes['created_at'] );
	}

	public function getCreatedAtFormattedAttribute()
	{
		return DataHelper::getPrettyDateTime( $this->attributes['created_at'] );
	}

	public function getEndAtTimeAttribute()
	{
		return strtotime( $this->attributes['end_at'] );
	}

	public function getEndAtFormattedAttribute()
	{
		return DataHelper::getPrettyDateTime( $this->attributes['end_at'] );
	}

	public function getCreatedAtFullFormattedAttribute()
	{
		return DataHelper::getFullPrettyDateTime( $this->attributes['created_at'] );
	}

    public function getFinishedAtTimeAttribute()
    {
        return strtotime( $this->attributes['finished_at'] );
    }

	public function getFinishedAtFormattedAttribute()
	{
		return DataHelper::getPrettyDateTime( $this->attributes['finished_at'] );
	}

	public function getFinishedAtFullFormattedAttribute()
	{
		return DataHelper::getFullPrettyDateTime( $this->attributes['finished_at'] );
	}


	//============================================================
	//======================== PORTION ===========================
	//============================================================

	public function getDueAtFormattedAttribute()
	{
		return DataHelper::getPrettyDate( $this->attributes['due_at'] );
	}

    public function getDueAtTimeAttribute()
    {
        return strtotime( $this->attributes['due_at'] );
    }

	public function getPaidAtFormattedAttribute()
	{
		return DataHelper::getPrettyDate( $this->attributes['paid_at'] );
	}

    public function getPaidAtTimeAttribute()
    {
        return strtotime( $this->attributes['paid_at'] );
    }

	public function getSettedAtFormattedAttribute()
	{
		return DataHelper::getPrettyDate( $this->attributes['setted_at'] );
	}

    public function getSettedAtTimeAttribute()
    {
        return strtotime( $this->attributes['setted_at'] );
    }


}