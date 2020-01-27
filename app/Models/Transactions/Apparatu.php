<?php

namespace App\Models\Transactions;

use App\Helpers\DataHelper;
use App\Models\Inputs\Equipment;
use App\Models\Inputs\Instruments\Instrument;
use App\Models\Inputs\Settings\LabelInstrument;
use App\Models\Inputs\Settings\SealInstrument;
use App\Models\Transactions\Settings\ApparatuPart;
use App\Models\Transactions\Settings\ApparatuService;
use App\Traits\ActiveTrait;
use App\Traits\ApparatuServicesTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;

class Apparatu extends Model
{
	use SoftDeletes;
	use ApparatuServicesTrait;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;

	protected $fillable = [
		'order_id',
		'instrument_id',
		'equipment_id',
		'defect',
		'solution',
		'call_number',

		'idaparelho_manutencao',
	];

	protected $appends = [
		'created_at_time','created_at_formatted',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function canShowInputs()
	{
		return ( $this->getAttribute('defect') != NULL && $this->getAttribute('solution') != NULL );
	}

	public function getName()
	{
		return $this->getAttribute('description');
	}

	public function getContent()
	{
		return $this->getAttribute('description');
	}

	public function getShortDescriptions()
	{
		return $this->getAttribute('description');
	}

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

	//============================================================
	//======================== SCOPES ============================
	//============================================================

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	public function has_instrument()
	{
		return ($this->getAttribute('instrument_id') != NULL);
	}

	public function has_equipment()
	{
		return ($this->getAttribute('equipment_id') != NULL);
	}

	//======================== FUNCTIONS =========================

//
//    static public function getRelatorioIpem($data)
//    {
//        $query = self::whereNotNull('idinstrumento');
//        if (isset($data['idtecnico'])) {
//            if ($data['idtecnico'] != "") {
//                $OS = OrdemServico::filterSeloIpem($data);
//                $query->whereIn('idordem_servico', $OS->pluck('idordem_servico'));
//            }
//        }
//        if (isset($data['numeracao_inicial'])) {
//            $selos = new Selo;
//            if ($data['numeracao_inicial'] != "") {
//                $selos = $selos->where('numeracao', '>=',  DataHelper::getOnlyNumbers($data['numeracao_inicial']));
//            }
//            if ($data['numeracao_final'] != "") {
//                $selos = $selos->where('numeracao', '<=',  DataHelper::getOnlyNumbers($data['numeracao_final']));
//            }
//            $query->whereIn('idaparelho_manutencao',
//                SeloInstrumento::whereIn('idselo',
//                    $selos->pluck('idselo')
//                )->pluck( 'idaparelho_set' )
//            //                    )->pluck('idaparelho_manutencao')
//            );
//        }
//
//        return $query->get()->map(function($r){
//            $Ordem_servico = $r->ordem_servico;
//            $Cliente = $Ordem_servico->cliente->getType();
//            $selo = $r->instrumento->numeracao_selo_afixado();
//            $r->ordem_servico   = $Ordem_servico;
//            $r->colaborador     = $Ordem_servico->colaborador;
//            $r->cliente         = $Cliente;
//
//            $r->selo_numeracao  = $selo['text'];
//            $r->selo_declared   = $selo['declared'];
//            $r->idselo          = $selo['id'];
//            return $r;
//        });
//    }
//
//
//
//    // ******************** INSUMOS *******************************
//    public function hasInsumoUtilizadoId($id, $tipo)
//    {
//        switch ($tipo) {
//            case 'servicos':
//                return $this->servico_prestados()->where('idservico', $id)->first();
//            case 'pecas':
//                return $this->pecas_utilizadas()->where('idpeca', $id)->first();
//        }
//
//    // ******************** PEÇAS ******************************
//    // *********************************************************

	public function apparatu_parts() //pecas_utilizadas()
	{
		return $this->hasMany(ApparatuPart::class, 'apparatu_id');
	}

	public function addPart(array $attributes)
	{
		$part = ApparatuPart::create([
			'apparatu_id'   => $this->id,
			'part_id'       => $attributes['id'],
			'value'         => $attributes['value'],
			'quantity'      => $attributes['quantity'],
			'discount'      => $attributes['discount']
		]);
		return [
			'part_id'               => $attributes['id'],
			'id'                    => $part->id,
			'name'                  => $part->parent_name,
//		    'value'                 => $part->value,
			'value_formatted'       => $part->value_formatted,
			'quantity'              => $part->quantity,
//		    'discount'              => $part->discount,
			'discount_formatted'    => $part->discount_formatted,
//		    'total'                 => $part->total,
			'total_formatted'       => $part->total_formatted
		];
	}

	public function remPart($id) //remove_pecas_utilizadas
	{
//	    $this->apparatu_services->find($id)->delete();
		ApparatuPart::destroy($id);
		return $this->order->updateValues();
	}

//    public function getTotalPecasReal($total = NULL)
    public function getTotalPartsFormatted($total = NULL)
    {
        $total = ($total == NULL) ? $this->getTotalParts() : $total;
        return DataHelper::getFloat2Currency($total);
    }

//    public function getTotalPecas()
    public function getTotalParts()//FAZER VIA DB
    {
        return $this->apparatu_parts->sum(function ($p) {
            return $p->total;
        });
    }
//
//    public function getTotalDescontoPecasReal($total = NULL)
//    {
//        $total = ($total == NULL) ? $this->getTotalDescontoPecas() : $total;
//        return DataHelper::getFloat2RealMoeda($total);
//    }
//
//    public function getTotalDescontoPecas()
//    {
//        return $this->pecas_utilizadas->sum('desconto');
//    }
//
//    public function valor_pecas_utilizadas()
//    {
//        return $this->hasMany('App\PecasUtilizadas', 'idaparelho_manutencao');
//    }
    // ************************************************************
    // ******************** SERVIÇOS ******************************
    // ************************************************************

	public function addService(array $attributes)
	{
		$service = ApparatuService::create([
			'apparatu_id'   => $this->id,
			'service_id'    => $attributes['id'],
			'value'         => $attributes['value'],
			'quantity'      => $attributes['quantity'],
			'discount'      => $attributes['discount']
		]);
		return [
			'service_id'            => $attributes['id'],
			'id'                    => $service->id,
			'name'                  => $service->parent_name,
//		    'value'                 => $service->value,
			'value_formatted'       => $service->value_formatted,
			'quantity'              => $service->quantity,
//		    'discount'              => $service->discount,
			'discount_formatted'    => $service->discount_formatted,
//		    'total'                 => $service->total,
			'total_formatted'       => $service->total_formatted
		];
	}

	public function remService($id) //remove_servico_prestados
	{
//	    $this->apparatu_services->find($id)->delete();
		ApparatuService::destroy($id);
		return $this->order->updateValues();
	}

    public function apparatu_services() //servico_prestados()
    {
        return $this->hasMany(ApparatuService::class, 'apparatu_id');
    }

//    public function getTotalServicosReal($total = NULL)
    public function getTotalServicesFormatted($total = NULL)
    {
        $total = ($total == NULL) ? $this->getTotalServices() : $total;
        return DataHelper::getFloat2Currency($total);
    }

    public function getTotalServices()
    {
        return $this->apparatu_services->sum(function ($p) {
            return $p->total;
        });
    }
//
//
//    // ******************** **** **********************************
//    // ************************************************************
//
//    public function get_total()
//    {
//        $total = 0;
//        $total += $this->getTotalPecas();
//        $total += $this->getTotalServicos();
//        return $total;
//    }
//
//    public function get_total_desconto()
//    {
//        $total = 0;
//        $total += $this->getTotalDescontoPecas();
//        $total += $this->getTotalDescontoServicos();
//        return $total;
//    }
//

	//============================================================
	//======================== SELOS =============================

	public function hasLabelSetted() //has_selo_afixado
    {
        return $this->label_instrument_set->count()>0;
    }

    public function hasLabelUnsetted() //has_selo_retirado
    {
        return $this->label_instrument_unset->count()>0;
    }

	public function getNumberLabelSetted() //numeracao_selo_afixado
	{
		return $this->instrument->getNumberLabelSetted($this->getAttribute('id'));
	}

    public function getNumberLabelUnsetted() //numeracao_selo_instrumento_retirado
    {
	    return $this->instrument->getNumberLabelUnsetted($this->getAttribute('id'));
    }


	//============================================================
	//======================== LACRES ============================

	public function hasSealsSetted() //has_lacres_afixados
	{
		return $this->seals_instrument_set->count() > 0;
	}

    public function hasSealsUnsetted() //has_lacres_retirados()
    {
        return $this->seals_instrument_unset->count() > 0;
    }

	public function getNumberSealsSetted() //numeracao_selo_afixado
	{
		return $this->instrument->getNumberSealsSetted($this->getAttribute('id'));
	}

	public function getNumberSealsUnsetted() //numeracao_selo_instrumento_retirado
	{
		return $this->instrument->getNumberSealsUnsetted($this->getAttribute('id'));
	}

	//======================== BELONGS ===========================

	//======================== HASMANY ===========================


	public function order()
	{
		return $this->belongsTo(Order::class, 'order_id');
	}

	public function instrument()
	{
		return $this->belongsTo(Instrument::class, 'instrument_id');
	}

	public function equipment()
	{
		return $this->belongsTo(Equipment::class, 'equipment_id');
	}

    public function label_instrument_set() //selo_instrumento_set
    {
        return $this->hasMany( LabelInstrument::class, 'apparatu_set_id', 'id' );
    }

    public function label_instrument_unset() //selo_instrumento_unset
    {
        return $this->hasMany( LabelInstrument::class, 'apparatu_unset_id', 'id' );
    }

    public function seals_instrument_set() //lacres_instrumento_set
    {
        return $this->hasMany( SealInstrument::class, 'apparatu_set_id', 'id' );
    }

    public function seals_instrument_unset() //lacres_instrumento_unset
    {
        return $this->hasMany( SealInstrument::class, 'apparatu_unset_id', 'id' );
    }

}
