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
use Illuminate\Support\Facades\Auth;

class SealInstrument extends Model {
    use SealLabelInstrumentTrait;
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    public $timestamps = true;
    protected $fillable = [
        'idlacre_instrumento',
        'instrument_id',
        'apparatu_set_id',
        'apparatu_unset_id',
        'seal_id',
        'external',
        'set_at',
        'unset_at',
    ];

    //======================== FUNCTIONS =========================
    //Somente Afixar o lacre na tabela LacreInstrumento
    static public function set( Apparatu $apparatu, array $seals_id, $now = null ) {
        $now = ( $now == null ) ? Carbon::now() : $now;
        foreach ( $seals_id as $id ) {
            Seal::setUsed( $id );
	        SealInstrument::create( [
                'seal_id'           => $id,
                'apparatu_set_id'   => $apparatu->id,
                'apparatu_unset_id' => null,
                'instrument_id'     => $apparatu->instrument_id,
                'set_at'            => $now,
                'unset_at'          => null,
            ] );
        }

        return true;
    }

    static public function _unset( Apparatu $apparatu, $seal_id, $now = null )
    {
        $now  = ( $now == null ) ? Carbon::now()->toDateTimeString() : $now;
	    $Data = SealInstrument::where('seal_id', $seal_id)->first();
        $Data->update( [
            'apparatu_unset_id' => $apparatu->id,
            'unset_at'          => $now,
            'external'          => $Data->seal->isExternal(),
        ] );
        return $Data;
    }

    static public function unsetHidden(Apparatu $apparatu, $seals_id, $now = NULL)
    {
	    $seals_id = json_decode($seals_id);
        //Nesse caso, o SeloInstrumento já existe, vamos atualizar o retirado_em
        if(count($seals_id)  > 1){
            foreach($seals_id as $key => $id){
	            SealInstrument::_unset( $apparatu, $id, $now );
            }
        } else {
            $id = $seals_id[0]->id;
	        SealInstrument::_unset( $apparatu, $id, $now );
        }
    }

    //Afixar e Retirar o lacre, neste caso quando é um lacre externo
    static public function unsetNew( Apparatu $apparatu, $lacre, $now = null ) {

        $now = ( $now == null ) ? Carbon::now()->toDateTimeString() : $now;

        $seal = Seal::create([ // se não existir, inserir e retornar o novo id
            'id'                => Auth::id(),
            'external_number'   => $lacre,
            'extern'            => 1,
            'used'              => 1,
        ]);

        return SealInstrument::create( [
            'seal_id'           => $seal->idlacre,
            'apparatu_set_id'   => $apparatu->id,
            'apparatu_unset_id' => $apparatu->id,
            'instrument_id'     => $apparatu->instrument_id,
            'set_at'            => $now,
            'unset_at'          => $now,
            'external'          => true,
        ] );

    }

	//Extornar lacre
    public function reverse() {
        $this->seal->reverse();
        return $this->delete();
    }

    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================


//    public function lacres()
//    {
//        return $this->belongsTo(Lacre::class, 'idlacre');
//    }


    //======================== FUNCTIONS =========================

    //======================== BELONGS ===========================

    public function seal()
    {
        return $this->belongsTo(Seal::class, 'seal_id');
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

    //======================== HASMANY =========================
    //======================== HASONE =========================

}
