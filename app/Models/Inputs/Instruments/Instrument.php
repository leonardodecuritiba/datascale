<?php

namespace App\Models\Inputs\Instruments;

use App\Models\Commons\Picture;
use App\Models\HumanResources\Client;
use App\Models\Inputs\Settings\LabelInstrument;
use App\Models\Inputs\Settings\SealInstrument;
use App\Models\Ipem\Pam;
use App\Models\Transactions\Apparatu;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\Relashionships\PictureTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class Instrument extends Model {
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
	use PictureTrait;
    public $timestamps = true;

	static public $img_path = 'equipments';
    protected $fillable = [
        'client_id',
        'pam_id',
        'instrument_setor_id',
        'label_identification_id',
        'label_inventory_id',

        'serial_number',
        'inventory',
        'patrimony',
        'year',
        'ip',
        'address',
        'active',

	    'idinstrumento',
    ];
    protected $appends = [
        'ip_address',
        'setor_name',
	    'image',
	    'thumb_image',
	    'label_identification_image',
	    'label_inventory_image',
    ];

    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================


    public function getLabelIdentificationImageAttribute()
    {
//        return ($this->label_identification_id != NULL) ?  asset($this->getLinkFile()) : asset('assets/images/temp.jpg');
//        return asset('assets/images/temp.jpg');
        return ($this->label_identification_id != NULL) ?  asset($this->label_identification->src) : NULL;
    }

    public function getLabelInventoryImageAttribute()
    {
//        return ($this->label_inventory_id != NULL) ?  asset($this->getLinkFile()) : asset('assets/images/temp.jpg');
//        return asset('assets/images/temp.jpg');
        return ($this->label_inventory_id != NULL) ?  asset(asset($this->label_inventory->src)) : NULL;
    }

    public function getFileView()
    {
    }


	public function getImageAttribute()
	{
		return $this->pam->getFileView();
	}

	public function getThumbImageAttribute()
	{
		return $this->pam->getThumbFileView();
	}

    public function getName()
    {
        return $this->getAttribute('description');
    }

    public function getContent()
    {
        return $this->getAttribute('description');
    }

    public function getIpAddressAttribute()
    {
        return $this->getAttribute('ip') . ( ($this->getAttribute('address') != NULL) ? ' / ' : '') . $this->getAttribute('address');
    }

    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================

	public function getBaseDescription() {
		return $this->pam->getBaseDescription();
	}

	public function getBrandModel() {
		return $this->pam->getBrandModel();
	}

	public function getBaseDivision() {
		return $this->pam->division;
	}

	public function getBaseCapacity() {
		return $this->pam->capacity;
	}

	public function getBaseOrdinance() {
		return $this->pam->ordinance;
	}

	public function getSetorNameAttribute() {
		return $this->instrument_setor->getName();
	}

    // ***********************************************************
    // HAS
	public function has_apparatus()
	{
		return ($this->apparatus()->count() > 0);
	}


	//============================================================
	//======================== SELOS =============================

	public function getNumberLabelSetted($idaparelho_set = NULL)
	{
		$label_instrument = $this->getLabelSetted($idaparelho_set);
		if($label_instrument->count() == 0) return NULL;

		$label = $label_instrument->first()->label;
		return [
			'id' => $label->id,
			'text'=> $label->number_formatted,
		];
	}

	public function getNumberLabelUnsetted($idaparelho_set = NULL)
	{
		$label_instrument = $this->getLabelUnsetted($idaparelho_set);
		if($label_instrument->count() == 0) return NULL;

		$label = $label_instrument->first()->label;
		return [
			'id' => $label->id,
			'text'=> $label->number_formatted,
		];
	}

	public function getLabelSetted($idaparelho_set = NULL)
	{
		return $this->label_instrument_set($idaparelho_set);
	}

	public function getLabelUnsetted($idaparelho_set = NULL)
	{
		return $this->label_instrument_unset($idaparelho_set);
	}


	//============================================================
	//======================== LACRES ============================


	public function getNumberSealsSetted($idaparelho_set = NULL)
	{
		$seals_instrument = $this->getSealsSetted($idaparelho_set);
		if($seals_instrument->count() == 0) return NULL;

		$seals_instrument = $seals_instrument->get();

		$text = NULL;
		$data = NULL;

		foreach($seals_instrument as $s){
			$id = $s->seal->id;
			$number = $s->seal->number_formatted;
			$data[] = [
				'id'    => $id,
				'text'  => $number,
			];
			$text[] = $number;
		}
		return [
			'data'  => $data,
			'text'  => implode('; ', $text),
		];
	}

	public function getNumberSealsUnsetted($idaparelho_set = NULL)
	{
		$seals_instrument = $this->getSealsUnsetted($idaparelho_set);
		if($seals_instrument->count() == 0) return NULL;

		$seals_instrument = $seals_instrument->get();

		$text = NULL;
		$data = NULL;

		foreach($seals_instrument as $s){
			$id = $s->seal->id;
			$number = $s->seal->number_formatted;
			$data[] = [
				'id'    => $id,
				'text'  => $number,
			];
			$text[] = $number;
		}
		return [
			'data'  => $data,
			'text'  => implode('; ', $text),
		];
	}

	public function getSealsSetted($idaparelho_set = NULL)
	{
		return $this->seals_instrument_set($idaparelho_set);
	}

	public function getSealsUnsetted($idaparelho_set = NULL)
	{
		return $this->seals_instrument_unset($idaparelho_set);
	}

	/*
	 *
	 *
	public function selo_instrumento_cliente() {
		$selosInstrumento = $this->selo_instrumentos;
		if ( $selosInstrumento->count() > 0 ) {
			return $selosInstrumento->map( function ( $s ) {
				$s->nome_tecnico = $s->selo->getNomeTecnico();
				$s->retirado_em  = $s->getUnsetText();
				$s->afixado_em   = $s->getSetText();
				$s->numeracao_dv = $s->selo->getFormatedSeloDV();

				return $s;
			} );
		}
		return null;
	}


    public function lacres_instrumento_cliente()
    {
        $lacresInstrumento = $this->lacres_instrumentos;
        if ($lacresInstrumento->count() > 0) {
            return $lacresInstrumento->map(function ($l) {
                $l->nome_tecnico = $l->lacre->getNomeTecnico();
                $l->retirado_em  = $l->getUnsetText();
                $l->afixado_em   = $l->getSetText();
                $l->numeracao    = $l->lacre->getNumeracao();
                return $l;
            });
        }
        return NULL;
    }

    */


    //======================== BELONGSTO =========================
	public function label_identification()
	{
		return $this->belongsTo(Picture::class, 'label_identification_id');
	}

	public function label_inventory()
	{
		return $this->belongsTo(Picture::class, 'label_inventory_id');
	}

    public function instrument_setor()
    {
        return $this->belongsTo(InstrumentSetor::class, 'instrument_setor_id');
    }

    public function pam()
    {
        return $this->belongsTo(Pam::class, 'pam_id');
    }

    public function client()
    {
        return $this->belongsTo( Client::class, 'client_id' );
    }

	//======================== HASMANY =========================

	public function apparatus()
    {
		return $this->hasMany( Apparatu::class, 'instrument_id' );
	}







	public function label_instruments()
	{
		return $this->hasMany( LabelInstrument::class, 'instrument_id' )->orderBy( 'set_at', 'DESC');
	}

	public function label_instrument_set($apparatu_set_id = NULL) //selo_instrumentos_afixado
	{
		$o = $this->label_instruments()
		          ->where('external',0);

		if($apparatu_set_id != NULL){
			$o->where('apparatu_set_id', $apparatu_set_id);
		}
		else {
			$o->whereNull('apparatu_unset_id');
		}
		return $o->orderBy( 'unset_at' , 'ASC');
	}

	public function label_instrument_unset($apparatu_unset_id = NULL) //selo_instrumentos_retirado
	{
		$o = $this->label_instruments()
		          ->whereNotNull( 'apparatu_unset_id' );

		if($apparatu_unset_id != NULL){
			$o->where('apparatu_unset_id', $apparatu_unset_id);
		}

		return $o->orderBy( 'unset_at' , 'DESC');
	}







	public function seals_instruments()
	{
		return $this->hasMany( SealInstrument::class, 'instrument_id' )->orderBy( 'set_at', 'DESC' );
	}

	public function seals_instrument_set($apparatu_set_id = NULL) //lacres_instrumentos_afixados
	{
		$o = $this->seals_instruments()
		          ->where('external',0);

		if($apparatu_set_id != NULL){
			$o->where('apparatu_set_id', $apparatu_set_id);
		} else {
			$o->whereNull('apparatu_unset_id');
		}
		return $o->orderBy( 'unset_at' , 'ASC');
	}

	public function seals_instrument_unset($apparatu_unset_id = NULL) //lacres_instrumentos_retirados
	{
		$o = $this->seals_instruments()
		          ->whereNotNull( 'apparatu_unset_id' );

		if($apparatu_unset_id != NULL){
			$o->where('apparatu_unset_id', $apparatu_unset_id);
		}
		return $o->orderBy( 'unset_at' , 'DESC');
	}


}
