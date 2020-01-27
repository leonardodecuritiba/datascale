<?php

namespace App\Models\Inputs\Instruments;

use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstrumentSetor extends Model {
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    public $timestamps = true;
    protected $fillable = [

        'idinstrumento_setor',

        'description',
        'active',
    ];

    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================
    public function getName()
    {
        return $this->getAttribute('description');
    }

    public function getContent()
    {
        return $this->getAttribute('description');
    }

    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================
    //======================== HASMANY ===========================
    public function instruments()
    {
        return $this->hasMany(Instrument::class, 'instrument_setor_id');
    }
}
