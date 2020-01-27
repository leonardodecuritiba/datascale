<?php

namespace App\Models\Inputs\Settings;

use App\Models\Inputs\Instruments\Instrument;
use App\Models\Transactions\Apparatu;
use App\Traits\DateTimeTrait;
use App\Traits\SealLabelInstrumentTrait;
use App\Traits\StringTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabelInstrument extends Model {
    use SealLabelInstrumentTrait;
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    public $timestamps = true;
    protected $fillable = [
        'idselo_instrumento',
        'instrument_id',
        'apparatu_set_id',
        'apparatu_unset_id',
        'label_id',
        'external',
        'set_at',
        'unset_at',
    ];

    //======================== FUNCTIONS =========================
    //Somente Afixar o selo na tabela SeloInstrumento
    static public function set( Apparatu $apparatu, $label_id, $now = null ) {
        $now = ( $now == null ) ? Carbon::now()->toDateTimeString() : $now;
        Label::setUsed( $label_id );
        return LabelInstrument::create( [
            'label_id'          => $label_id,
            'apparatu_set_id'   => $apparatu->id,
            'apparatu_unset_id' => null,
            'instrument_id'     => $apparatu->instrument_id,
            'set_at'            => $now,
            'unset_at'          => null,
            'external'          => false,
        ] );
    }

    static public function unsetHidden(Apparatu $apparatu, $labels_id, $now = NULL)
    {
        $unsetted_labels = json_decode($labels_id);
        //Nesse caso, o SeloInstrumento já existe, vamos atualizar o retirado_em
        if(count($unsetted_labels)  > 1){
            foreach($unsetted_labels as $key => $id){
	            LabelInstrument::_unset( $apparatu, $id, $now );
            }
        } else {
            $id = $unsetted_labels;
	        LabelInstrument::_unset( $apparatu, $id, $now );
        }
    }

    //Nesse caso, criar o SeloInstrumento já existe, vamos atualizar o unset_at
    static public function _unset( Apparatu $apparatu, $label_id, $now = null )
    {
        $now  = ( $now == null ) ? Carbon::now()->toDateTimeString() : $now;
        $Data = LabelInstrument::where('label_id', $label_id)->first();
        $Data->update( [
            'apparatu_unset_id' => $apparatu->id,
            'unset_at'          => $now,
            'external'          => $Data->label->isExternal(),
        ] );
        return $Data;
    }

    //Afixar e Retirar o selo, neste caso quando é um selo externo
    static public function unsetNew( Apparatu $apparatu, $label, $now = null ) {
        $now = ( $now == null ) ? Carbon::now()->toDateTimeString() : $now;

	    $label = Label::create([ // se não existir, inserir e retornar o novo id
            'owner_id'          => Auth::id(),
            'external_number'   => $label,
            'extern'            => 1,
            'used'              => 1,
        ]);

        return LabelInstrument::create( [
            'label_id'          => $label->id,
            'apparatu_set_id'   => $apparatu->id,
            'apparatu_unset_id' => $apparatu->id,
            'instrument_id'     => $apparatu->instrument_id,
            'set_at'            => $now,
            'unset_at'          => $now,
            'external'          => true,
        ] );
    }

    //Extornar selo
    public function reverse() {
        $this->label->reverse();
        return $this->delete();
    }


    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================

    //======================== FUNCTIONS =========================

    //======================== BELONGS ===========================

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id');
    }

    public function apparatu_set()
    {
        return $this->belongsTo(Apparatu::class, 'apparatu_set_id');
    }

    public function apparatu_unset()
    {
        return $this->belongsTo(Apparatu::class, 'apparatu_unset_id');
    }

    //======================== HASMANY ===========================
    //======================== HASONE ============================

}
