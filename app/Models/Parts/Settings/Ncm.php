<?php

namespace App\Models\Parts\Settings;

use App\Helpers\DataHelper;
use App\Models\Parts\Part;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ncm extends Model
{
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    public $timestamps = true;
    protected $appends = [
        'created_at_time','created_at_formatted',
        'ipi_formatted','pis_formatted','cofins_formatted','nacional_formatted','importacao_formatted',
    ];
    protected $fillable = [
        'code',
        'description',
        'ipi',
        'pis',
        'cofins',
        'nacional',
        'importacao',
        'active',

	    'idncm',
    ];


    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================

    static public function getAlltoSelectList() {
        return self::active()->get()->map( function ( $s ) {
            return [
                'id'          => $s->id,
                'description' => $s->getName()
            ];
        } )->pluck( 'description', 'id' );
    }


    public function getName()
    {
        return $this->getAttribute('code');
    }
    public function getContent()
    {
        return $this->getAttribute('description');
    }

    // aliquota_ipi (%)
    public function setIpiAttribute($value)
    {
        $this->attributes['ipi'] = DataHelper::getReal2Float($value);
    }
    public function getIpiFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->attributes['ipi']);
    }
    // pis (%)
    public function setPisAttribute($value)
    {
        $this->attributes['pis'] = DataHelper::getReal2Float($value);
    }
    public function getPisFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->attributes['pis']);
    }
    // cofins (%)
    public function setCofinsAttribute($value)
    {
        $this->attributes['cofins'] = DataHelper::getReal2Float($value);
    }
    public function getCofinsFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->attributes['cofins']);
    }
    // nacional (%)
    public function setNacionalAttribute($value)
    {
        $this->attributes['nacional'] = DataHelper::getReal2Float($value);
    }
    public function getNacionalFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->attributes['nacional']);
    }
    // importacao (%)
    public function setImportacaoAttribute($value)
    {
        $this->attributes['importacao'] = DataHelper::getReal2Float($value);
    }
    public function getImportacaoFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->attributes['importacao']);
    }

    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================
    public function parts()
    {
        return $this->hasMany(Part::class, 'ncm_id');
    }
}
