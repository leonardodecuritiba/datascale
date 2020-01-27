<?php

namespace App\Models\Inputs\Settings;

use App\Helpers\DataHelper;
use App\Models\Users\User;
use App\Traits\DateTimeTrait;
use App\Traits\SealLabelTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Label extends Model {
    use SealLabelTrait;
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    public $timestamps = true;
    protected $fillable = [
        'idselo',
        'owner_id',
        'number',
        'external_number',
        'extern',
        'used',
        'declared_at',
    ];

	protected $appends = [
		'number_formatted',

		'status_color',
		'status_text',
	];



	//======================== FUNCTIONS =========================

	public function getNumberFormattedAttribute()
	{
		return $this->getFormattedNumberDV();
	}


    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================

    //======================== FUNCTIONS =========================
	public function getFormattedNumber()
	{
		if ($this->isExternal()) {
			$n = $this->getAttribute('external_number');
			return ($n != NULL) ? $n : '-';
		}
		$n = $this->getAttribute('number');
		return ($n != NULL) ? DataHelper::mask($n, '##.###.###') : '-';
	}

    public function getFormattedNumberDV()
    {
	    if ($this->isExternal()) {
		    $n = $this->getAttribute('external_number');
		    return ($n != NULL) ? $n : '-';
	    }
	    $n = ($this->getAttribute('number') != NULL) ? $this->getAttribute('number') . $this->getDV() : NULL;
	    return ($n != NULL) ? DataHelper::mask($n, '##.###.###-#') : '-';
    }

	public function getDV()
	{
		return DataHelper::calculateModulo11($this->getAttribute('number'));
	}



//    static public function set_declared($id)
//    {
//        return self::findOrFail($id)
//            ->update(['declared' => Carbon::now()]);
//    }
//
//    static public function set_undeclared($id)
//    {
//        return self::findOrFail($id)
//            ->update(['declared' => NULL]);
//    }
//
//    static public function assign($data)
//    {
//        return self::whereIn('idselo', $data['valores'])
//            ->update(['idtecnico' => $data['idtecnico']]);
//    }
//
//    static public function selo_exists($numeracao)
//    {
//        return (self::where('numeracao', $numeracao)->exists() > 0);
//    }
//
//    public function scopeNumeracao($query, $numeracao)
//    {
//        return $query->where('numeracao', 'like', '%' . $numeracao . '%')
//            ->orWhere('numeracao_externa', 'like', '%' . $numeracao . '%');
//    }
//
//
//    public function getOrdemServicoID()
//    {
//        $selo_i = $this->selo_instrumento;
//        if($selo_i!=NULL){
//            return $selo_i->aparelho_set->idordem_servico;
//        }
//        return $selo_i;
//    }
//
//


//    public function has_selo_instrumento()
//    {
//        return ($this->selo_instrumento()->count() > 0);
//    }
    //======================== BELONGS ===========================
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    //======================== HASMANY =========================
    //======================== HASONE =========================
    public function label_instrument()
    {
        return $this->hasOne(LabelInstrument::class, 'label_id');
    }

}
