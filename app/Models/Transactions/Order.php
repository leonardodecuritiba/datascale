<?php

namespace App\Models\Transactions;

use App\Helpers\DataHelper;
use App\Models\HumanResources\Client;
use App\Models\Transactions\Settings\ApparatuPart;
use App\Models\Transactions\Settings\ApparatuService;
use App\Models\Users\User;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\Orders\OrderFlowTrait;
use App\Traits\Orders\OrderPoliciesTrait;
use App\Traits\Orders\OrderValuesTrait;
use App\Traits\Orders\OrderStatusTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    use OrderValuesTrait;
    use OrderFlowTrait;
    use OrderStatusTrait;
    use OrderPoliciesTrait;

    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    public $timestamps = true;

//    public $valores = [];
//    private $valor_desconto, $valor_acrescimo;

    protected $fillable = [
        'idordem_servico',

        'client_id',
        'user_id',
        'status',
        'cost_center_id',
        'billing_id',

        'finished_at', //data_finalizada
        'closed_at', //data_fechada
        'call_number',
        'responsible',
        'responsible_cpf',
        'responsible_position',

        'total_value',
        'discount_tec',
        'increase_tec',
        'final_value',

        'travel_cost',
        'tolls',
        'other_cost',
        'exemption_cost'
    ];

    protected $appends = [
        'created_at_time','created_at_formatted','created_at_full_formatted',
        'finished_at_time','finished_at_formatted','finished_at_full_formatted',

        'status_text',
        'status_color',
        'status_icon',
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

    public function getShortDescriptions()
    {
        return $this->getAttribute('description');
    }

    public function getPeriodText()
    {
        return DataHelper::getPeriodText($this->created_at_time);
    }


//

//
////        return $valores;
//
//        foreach ($valores as $val) {
//            foreach ($val as $key => $value) {
//                $_VALORES[$key] += floatval($val[$key]);
//            }
//        }
//        return $_VALORES;
//    }
//    static public function getSituacaoSelect()
//    {
////        if (Auth::user()->hasRole(['admin', 'financeiro'])){
////            $retorno = [
////                'todas' => 'Todas',
////                'abertas' => 'Abertas',
////                'atendimento-em-andamento' => 'Em Atendimento',
////                'finalizadas' => 'Finalizadas',
////                'pendentes' => 'Pendentes',
////                'faturadas' => 'Faturadas',
////            ];
////        } else {
////            $retorno = [
////                'todas' => 'Todas',
////                'abertas' => 'Abertas',
////                'atendimento-em-andamento' => 'Em Atendimento',
////                'finalizadas' => 'Finalizadas',
////                'pendentes' => 'Pendentes',
////                'faturadas' => 'Faturadas',
////            ];
////        }
////        return [
////            'abertas' => 'Abertas',
////            'atendimento-em-andamento' => 'Em Atendimento',
////            'finalizadas' => 'Finalizadas'
////        ];
//        return [
//            'todas' => 'Todas',
//            self::_STATUS_ABERTA_ => 'Abertas',
//            self::_STATUS_ATENDIMENTO_EM_ANDAMENTO_ => 'Em Atendimento',
//            self::_STATUS_FINALIZADA_ => 'Finalizadas',
//            self::_STATUS_FATURAMENTO_PENDENTE_ => 'Faturamento Pendente',
//            self::_STATUS_FATURADA_ => 'Faturadas',
//        ];
//    }

    // ******************** FILTERS ******************************
//    static public function centro_custo_os($data)
//    {
//        $query = self::filter_situacao_cliente($data);
//        return $query->where('idcentro_custo', $data['idcentro_custo']);
//    }
//    static public function filter_situacao_cliente($data)
//    {
//        $query = self::filter_situacao($data)
//            ->with('cliente', 'colaborador');
//        if (isset($data['idcliente']) && ($data['idcliente'] != "")) {
//            $query->where('idcliente', $data['idcliente']);
//        }
//        return $query;
//    }
//    static public function filter_layout($data)
//    {
//        $query = self::filter_situacao($data);
//        return (isset($data['centro_custo']) && $data['centro_custo']) ? $query->centroCustos() : $query->clientes();
//    }
//
//    static public function filter_situacao($data)
//    {
//        $data['situacao'] = (isset($data['situacao'])) ? $data['situacao'] : NULL;
//        $query = OrdemServico::orderBy('idordem_servico', 'desc');
//        switch ($data['situacao']) {
//            case self::_STATUS_ATENDIMENTO_EM_ANDAMENTO_:
//                $query->where('idsituacao_ordem_servico', self::_STATUS_ATENDIMENTO_EM_ANDAMENTO_);
//                break;
//            case self::_STATUS_FINALIZADA_:
//                $query->where('idsituacao_ordem_servico', self::_STATUS_FINALIZADA_);
//                break;
//            case self::_STATUS_ABERTA_:
//                $query->where('idsituacao_ordem_servico', self::_STATUS_ABERTA_);
//                break;
//            case self::_STATUS_FATURADA_:
//                $query->where('idsituacao_ordem_servico', self::_STATUS_FATURADA_);
//                break;
//            case self::_STATUS_FATURAMENTO_PENDENTE_:
//                $query->where('idsituacao_ordem_servico', self::_STATUS_FATURAMENTO_PENDENTE_);
//                break;
////            default:
////                $query->where('idsituacao_ordem_servico', self::_STATUS_ABERTA_);
////                break;
//        }
//        if (isset($data['data'])) {
//            $query->where( 'created_at', '>=', DataHelper::getPrettyToCarbonZero( $data['data'] ) );
//        }
//
//        $User = Auth::user();
//        if ($User->hasRole('tecnico')) {
//            $query->where('idcolaborador', $User->colaborador->idcolaborador);
//        }
////        dd($query);
//        return $query;
//    }
//
//    static public function filterSeloIpem($data)
//    {
//        $query = self::getByIDtecnico($data['idtecnico']);
//        if ($data['data_inicial'] != "") {
//            $query->where('created_at', '>=', DataHelper::getPrettyToCorrectDateTime($data['data_inicial']));
//        }
//        if ($data['data_final'] != "") {
//            $query->where('created_at', '<=', DataHelper::getPrettyToCorrectDateTime($data['data_final']));
//        }
//        return $query;
//    }
//
//    static public function getByIDtecnico($idtecnico)
//    {
//        if ($idtecnico == 0) {
//            $query = OrdemServico::whereNotNull('idcolaborador');
//        } else {
//            $Tecnico = Tecnico::findOrFail($idtecnico);
//            $query = self::where('idcolaborador', $Tecnico->idcolaborador);
//        }
//        return $query;
//    }
//
//    static public function filter_situacao_centro_custo($data)
//    {
//        $query = self::filter_situacao($data)
//            ->with('centro_custo')
//            ->whereNotNull('idcentro_custo')
//            ->groupBy('idcentro_custo');
//        if (isset($data['idcentro_custo']) && ($data['idcentro_custo'] != "")) {
//            $query->where('idcentro_custo', $data['idcentro_custo']);
//        }
//        return $query;
//    }


    // ******************** VALORES ******************************
    public function updateValues()
    {
        $total = $this->getTotalServices() + $this->getTotalParts();
        $increases = $total * ($this->getAttribute('increase_tec') / 100);
        $discounts = $total * ($this->getAttribute('discount_tec') / 100);

	    /*
        if ($data != NULL) {
            $valor = DataHelper::getReal2Float($data['valor']);
            if ($data['tipo']) { //acrescimo
                $max = $this->tecnico->acrescimo_max_float();
                $valor = ($valor > $max) ? $max : $valor;
                $this->attributes['acrescimo_tecnico'] = $valor;
                $acrescimos = $valor_total * ($valor / 100);
            } else { //desconto
                $max = $this->tecnico->desconto_max_float();
                $valor = ($valor > $max) ? $max : $valor;
                $this->attributes['desconto_tecnico'] = $valor;
                $descontos = $valor_total * ($valor / 100);
            }
        }
        */
        $this->attributes['total_value'] = $total - $discounts + $increases;

	    $this->attributes['final_value'] =
		    $this->getAttribute('total_value') +
		    $this->getAttribute('travel_cost') +
		    $this->getAttribute('tolls') +
		    $this->getAttribute('other_cost');
	    return $this->save();
    }
//    public function get_valor_total()
//    {
//        $valor_total = $valor_servicos = $valor_pecas = $valor_kits = 0;
//        foreach ($this->aparelho_manutencaos as $aparelho_manutencao) {
//            $valor_servicos += $aparelho_manutencao->getTotalServicos();
//            $valor_pecas += $aparelho_manutencao->getTotalPecas();
//            $valor_kits += $aparelho_manutencao->getTotalKits();
//        }
//
//        $this->valor_desconto = ($this->attributes['desconto_tecnico'] * $valor_servicos / 100);
//        $this->valor_acrescimo = ($this->attributes['acrescimo_tecnico'] * $valor_servicos / 100);
//        $valor_total = $valor_servicos + $valor_pecas + $valor_kits
//            - $this->valor_desconto + $this->valor_acrescimo;
//        return $valor_total;
//    }
//
//

    // ******************** PEÇAS ******************************

	public function getPartsClosure()
	{
		return ApparatuPart::whereIn('apparatu_id', $this->apparatus->pluck('id'))->get();
	}

	public function getTotalParts() //fechamentoPeçasTotal()
	{
		return DB::table('apparatu_parts')
		         ->whereIn('apparatu_id', $this->apparatus->pluck('id'))
		         ->whereNull('deleted_at')
		         ->sum(DB::raw('(quantity * value) - discount'));
	}

	public function getTotalDiscountParts() //fechamentoServicos()
	{
		return DB::table('apparatu_parts')
		         ->whereIn('apparatu_id', $this->apparatus->pluck('id'))
		         ->whereNull('deleted_at')
		         ->sum('discount');
	}

//    public function fechamentoPecasTotalReal($total = NULL)
//    {
//        $total = ($total == NULL) ? $this->fechamentoPecasTotalFloat() : $total;
//        return DataHelper::getFloat2RealMoeda($total);
//    }
//
//    public function fechamentoTotalDescontoPecasReal($total = NULL)
//    {
//        $total = ($total == NULL) ? $this->fechamentoTotalDescontoPecas() : $total;
//        return DataHelper::getFloat2RealMoeda($total);
//    }

    // ******************** SERVIÇOS ******************************

	public function getServicesClosure()
	{
		return ApparatuService::whereIn('apparatu_id', $this->apparatus->pluck('id'))->get();
	}

	public function getTotalServices() //fechamentoServicosTotal()
    {
//	    $time_start = microtime(true);
//	    $execution_time = (microtime(true) - $time_start);
//	    return '<b>Total Execution Time:</b> '.$execution_time.' s';
	    return DB::table('apparatu_services')
	      ->whereIn('apparatu_id', $this->apparatus->pluck('id'))
	      ->whereNull('deleted_at')
	      ->sum(DB::raw('(quantity * value) - discount'));
    }

	public function getTotalDiscountServices() //fechamentoTotalDescontoServicosReal()
	{
		return DB::table('apparatu_services')
		         ->whereIn('apparatu_id', $this->apparatus->pluck('id'))
		         ->whereNull('deleted_at')
		         ->sum('discount');
	}

    // ***************************************************

//
//    public function getStatusText()
//    {
//        return $this->situacao->descricao;
//    }


//    public function getStatusType()
//    {
//        switch ($this->attributes['idsituacao_ordem_servico']) {
//            case self::_STATUS_ABERTA_:
//                return 'info';
//            case self::_STATUS_FINALIZADA_:
//                return 'danger';
//            case self::_STATUS_FATURADA_:
//                return 'success';
//            default:
//                return 'warning';
//        }
//    }

    //============================================================
    //======================== ACCESSORS =========================
    //============================================================
//    public function getResponsavelCpfAttribute($value)
//    {
//        return DataHelper::mask($value, '###.###.###-##');
//    }
//
//    public function get_desconto_tecnico_real()
//    {
//        return DataHelper::getFloat2Real($this->attributes['desconto_tecnico']);
//    }
//
//    public function get_acrescimo_tecnico_real()
//    {
//        return DataHelper::getFloat2Real($this->attributes['acrescimo_tecnico']);
//    }
//    public function getValorFinalReal()
//    {
//        return DataHelper::getFloat2RealMoeda($this->attributes['valor_final']);
//    }
//
//    public function getDescontoTecnicoReal()
//    {
//        return DataHelper::getFloat2RealMoeda($this->getValorTotal() * ($this->attributes['desconto_tecnico'] / 100));
//    }
//
//    public function getAcrescimoTecnicoReal()
//    {
//        return DataHelper::getFloat2RealMoeda($this->getValorTotal() * ($this->attributes['acrescimo_tecnico'] / 100));
//    }
//
//    public function getDataAbertura()
//    {
//        return DataHelper::getFullPrettyDateTime($this->attributes['created_at']);
//    }
//
//    public function getDataFinalizada()
//    {
//        return DataHelper::getFullPrettyDateTime($this->attributes['data_finalizada']);
//    }
//    public function getCustosDeslocamentoReal()
//    {
//        return DataHelper::getFloat2RealMoeda($this->attributes['custos_deslocamento']);
//    }
//
//    public function getPedagiosReal()
//    {
//        return DataHelper::getFloat2RealMoeda($this->attributes['pedagios']);
//    }
//
//    public function getOutrosCustosReal()
//    {
//        return DataHelper::getFloat2RealMoeda($this->attributes['outros_custos']);
//    }
//
//    public function fechamentoValorTotalReal()
//    {
//        return DataHelper::getFloat2RealMoeda($this->attributes['valor_total']);
//    }
//
//    public function fechamentoValorFinalReal()
//    {
//        return DataHelper::getFloat2RealMoeda($this->attributes['valor_final']);
//    }

    //============================================================
    //======================== MUTATORS ==========================
    //============================================================

//    public function setCustosDeslocamentoAttribute($value)
//    {
//        $this->attributes['custos_deslocamento'] = DataHelper::getReal2Float($value);
//    }
//
//    public function setPedagiosAttribute($value)
//    {
//        $this->attributes['pedagios'] = DataHelper::getReal2Float($value);
//    }
//
//    public function setOutrosCustosAttribute($value)
//    {
//        $this->attributes['outros_custos'] = DataHelper::getReal2Float($value);
//    }



    //============================================================
    //======================== SCOPES ============================
    //============================================================

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCostCenters($query) //scopeCentroCustos
    {
        return $query->whereNotNull('cost_center_id');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClients($query) //scopeClientes
    {
        return $query->whereNull('cost_center_id');
    }


    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================

	public function checkApparatuExists($apparatu_id)
	{
		return $this->apparatus->where('id',$apparatu_id)->count();
	}

	public function remApparatu($apparatu_id)
	{
		return $this->apparatus->find($apparatu_id)->delete();
	}
//    public function has_aparelho_manutencaos()
//    {
//        return ($this->aparelho_manutencaos()->count() > 0);
//    }

    //======================== FUNCTIONS =========================
//    public function aparelho_manutencaos_totais()
//    {
//        return $this->aparelho_manutencaos->map(function ($ap) {
//            //,'kits_utilizados','servico_prestados']
//            $ap->total_servicos = $ap->getTotalServicos();
//            $ap->total_pecas = $ap->getTotalPecas();
//            $ap->total_kits = $ap->getTotalKits();
//            $ap->total_servicos_real = $ap->getTotalServicosReal();
//            $ap->total_pecas_real = $ap->getTotalPecasReal();
//            $ap->total_kits_real = $ap->getTotalKitsReal();
//            $ap->selo_instrumentos = $ap->selo_instrumentos;
//            $ap->lacre_instrumentos = $ap->lacre_instrumentos;
//            return $ap;
//        });
//    }

    //======================== BELONGS ===========================

    public function cost_center()
    {
        return $this->belongsTo(Client::class, 'cost_center_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function faturamento()
    {
        return $this->belongsTo(Billing::class, 'billing_id');
    }

    //======================== HASMANY ===========================
    public function apparatu_instruments()
    {
        return $this->hasMany(Apparatu::class, 'order_id')->whereNotNull('instrument_id');
    }

	public function apparatu_equipments()
	{
		return $this->hasMany(Apparatu::class, 'order_id')->whereNotNull('equipment_id');
	}

	public function apparatus()
	{
		return $this->hasMany(Apparatu::class, 'order_id');
	}

}
