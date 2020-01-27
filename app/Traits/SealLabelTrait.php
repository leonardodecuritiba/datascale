<?php

namespace App\Traits;

use App\Models\Inputs\Settings\LabelSealStatus;

trait SealLabelTrait
{

	static public function assign($data)
	{
		return self::whereIn('id', $data['values'])
		           ->update(['owner_id' => $data['user_id']]);
	}

    static public function setUsed($id)
    {
        $Data = self::find($id);
        $Data->update(['used' => 1]);
	    return $Data;
    }

	public function reverse()
	{
		if ($this->extern == 1) {
			$this->forceDelete();
		} else {
			$this->used = 0;
			$this->save();
		}
		return;
	}

//
//    public function repassaTecnico($idtecnico)
//    {
//        $this->idtecnico = $idtecnico;
//        return $this->save();
//    }

    public function isExternal()
    {
        return (($this->getAttribute('external_number')!= NULL) && ($this->getAttribute('number') == NULL));
    }

	public function getStatusColorAttribute()
	{
		switch ($this->getAttribute('used') + 1) {
			case LabelSealStatus::_STATUS_DISPONIVEL_:
				return 'success';
			case LabelSealStatus::_STATUS_USADO_:
				return 'danger';
		}
	}

	public function getStatusTextAttribute()
	{
		return LabelSealStatus::whereId($this->getAttribute('used') + 1)->description;
	}

}