<?php

namespace App\Models\Financials;

use App\Models\HumanResources\Client;
use App\Models\Transactions\Apparatu;
use App\Models\Transactions\Order;
use App\Models\Transactions\Settings\ApparatuPart;
use App\Traits\Billings\BillingNFeTrait;
use App\Traits\Billings\BillingScopesTrait;
use App\Traits\Billings\BillingStatusTrait;
use App\Traits\Billings\BillingValuesTrait;
use App\Traits\Billings\BillingFlowTrait;
use App\Traits\Billings\PaymentTrait;
use App\Traits\DateTimeTrait;
use App\Traits\Orders\OrderStatusTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Billing extends Model
{

    use BillingValuesTrait;
    use BillingScopesTrait;
    use BillingNFeTrait;
    use BillingStatusTrait;
    use BillingFlowTrait;
    use PaymentTrait;
    use SoftDeletes;
    use DateTimeTrait;
    public $timestamps = true;

    protected $fillable = [
        'idfaturamentos',
        'client_id',
        'status',
        'payment_id',
        'nfe_id_homologacao',
        'nfe_date_homologacao',
        'nfe_id_producao',
        'nfe_date_producao',
        'nfse_id_homologacao',
        'nfse_date_homologacao',
        'nfse_id_producao',
        'nfse_date_producao',
        'nfe_link',
        'nfse_link',
        'cost_center'
    ];


	protected $appends = [
		'created_at_time','created_at_formatted','created_at_full_formatted',
//		'finished_at_time','finished_at_formatted','finished_at_full_formatted',

		'status_icon',
		'status_color',
		'status_text',
	];
    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================

	public function bill()
	{
		$this->attributes['status'] = BillingStatusTrait::$_STATUS_FINALIZADO_;
		DB::table('orders')
		  ->where('billing_id', $this->id)
		  ->update(['status' => OrderStatusTrait::$_STATUS_FATURADA_]);
//		foreach ($this->orders as $order) {
//			$order->status = OrderStatusTrait::$_STATUS_FATURADA_;
//			$order->save();
//		}
		return $this->save();
	}

    public function close()
    {
        return $this->update([
            'status' => self::$_STATUS_FINALIZADO_
        ]);
    }

//
//    static public function faturaPeriodo($OrdemServicos)
//    {
//        $faturamento_cc = []; //faturamento centro de custos
//        $faturamento_cl = []; //faturamento clientes
//        foreach ($OrdemServicos as $ordem_servico) {
//            if ($ordem_servico->idcentro_custo != NULL) {
//                $idcentro_custo = $ordem_servico->idcentro_custo;
//                $faturamento_cc[$idcentro_custo][] = $ordem_servico;
//            } else {
//                $idcliente = $ordem_servico->idcliente;
//                $faturamento_cl[$idcliente][] = $ordem_servico;
//            }
//        }
//
//        //faturamentos CLIENTES
//        foreach ($faturamento_cl as $ordem_servicos) {
//            Faturamento::geraFaturamento($ordem_servicos, 0, $op = 1);
//        }
//
//        //faturamentos CENTRO DE CUSTO
//        foreach ($faturamento_cc as $ordem_servicos) {
//            Faturamento::geraFaturamento($ordem_servicos, 1, $op = 1);
//        }
//
//        return Faturamento::lastCreated()->first();
//
//    }

//
//    static public function filter_layout($data)
//    {
//        $query = self::filter_status($data);
//        return (isset($data['centro_custo']) && $data['centro_custo']) ? $query->centroCustos() : $query->clientes();
//    }
//
//    static public function filter_status($data)
//    {
//        $data['situacao'] = (isset($data['situacao'])) ? $data['situacao'] : NULL;
//        $query = self::orderBy('created_at', 'desc');
//        if ($data['situacao'] != NULL) $query->where('idstatus_faturamento', $data['situacao']);
//        if (isset($data['idcliente']) && ($data['idcliente'] != NULL)) $query->where('idcliente', $data['idcliente']);
////        if (isset($data['data'])) {
////            $query->where('created_at', '>=', DataHelper::getPrettyToCorrectDateTime($data['data']));
////        }
////        $User = Auth::user();
////        if ($User->hasRole('tecnico')) {
////            $query->where('idcolaborador', $User->colaborador->idcolaborador);
////        }
//        return $query;
//    }

    //============================================================
    //======================== ACCESSORS =========================
    //============================================================

    //============================================================
    //======================== MUTATORS ==========================
    //============================================================


    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================

    public function getAllParts()
    {
        $ids = Apparatu::whereIn('order_id', $this->orders->pluck('id'))
            ->pluck('id');
        return ApparatuPart::whereIn('apparatu_id', $ids)
            ->with('part')
//            ->groupBy('part_id')
            ->get();


//        return ApparatuPart::whereIn('apparatu_id', $ids)
////            ->with('part')
////            ->groupBy('part_id')
//            ->select('*', DB::raw('
//                SUM(discount) as desconto_total,
//                SUM(quantity) as quantidade_comercial,
//                (SUM(quantity) * value) as valor_bruto
//            '))
//            ->get();
    }
//
//    public function getAparelhoManutencaos()
//    {
//        return AparelhoManutencao::whereIn('idordem_servico', $this->ordem_servicos->pluck('idordem_servico'))->get();
//    }
//
//
//    public function deleteAll()
//    {
//        foreach (self::all() as $item) {
//            $item->delete();
//        }
//    }

//    public function getDataFechamento()
//    {
//        return DataHelper::getPrettyDateTime($this->attributes['created_at']);
//    }
//
//    public function getCreatedAtMonth()
//    {
//        return DataHelper::getPrettyDateTimeToMonth($this->attributes['created_at']);
//    }
//
//    public function getTipoFaturamento()
//    {
//        return ($this->centro_custo == 1) ? 'Centro de Custo' : 'Cliente';
//    }
//
//    public function getDataNF($tipo)
//    {
//        return DataHelper::getPrettyDateTime($this->attributes[$tipo]);
//    }
//

    //======================== BELONGS ===========================
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    //======================== HASONE ============================


    //======================== HASMANY ===========================
    public function orders()
    {
        return $this->hasMany(Order::class, 'billing_id');
    }
}
