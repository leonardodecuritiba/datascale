<?php

namespace App\Http\Controllers\Financials;

use App\Filters\BillingFilter;
use App\Filters\OrderFilter;
use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Models\Financials\Billing;
use App\Models\Financials\Payment;
use App\Models\Financials\Settings\BillingStatus;
use App\Models\Financials\Settings\BillingTypes;
use App\Models\HumanResources\Client;
use App\Models\Transactions\Order;
use App\Models\Transactions\Settings\OrderStatus;
use App\Traits\Orders\OrderStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
	public $entity = "billings";
	public $sex = "M";
	public $name = "Faturamento";
	public $names = "Faturamentos";
	public $main_folder = 'pages.financials.billings';
	public $page = [];
	public $OrderFilter;
	public $BillingFilter;

	public function __construct( Route $route ) {
		parent::__construct();
		$this->page = (object) [
			'entity'      => $this->entity,
			'main_folder' => $this->main_folder,
			'name'        => $this->name,
			'names'       => $this->names,
			'sex'         => $this->sex,
			'auxiliar'    => array(),
			'response'    => array(),
			'title'       => '',
			'create_option' => 0,
			'subtitle'    => '',
			'noresults'   => '',
			'tab'         => 'data',
			'breadcrumb'  => array(),
		];
		$this->breadcrumb( $route );
		$this->BillingFilter = new BillingFilter();
		$this->OrderFilter = new OrderFilter();
	}


	/**
	 * Display a listing of the Orders.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */

	public function report(Request $request) {
		$billings = $this->user->billings();
		$this->page->response = $this->BillingFilter->map($request, $billings);

		$this->page->auxiliar = [
			'clients'   => Client::getAlltoSelectList(),
			'status'    => BillingStatus::getAlltoSelectList(),
			'types'    => BillingTypes::getAlltoSelectList(),
		];
		$this->page->title = 'Relatório de Faturamentos para Clientes';
		$this->page->create_option = 0;

		return view('pages.financial.billings.clients.report' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$billings = $this->user
			->billings()
			->clients()
			->oppened()
			->get()
			->map( function($s) {
				$client = $s->client;
				return [
					'id'                => $s->id,
					'name'              => " #" . $s->id,
					'created_at'        => $s->created_at_formatted,
					'created_at_time'   => $s->created_at_time,

					'payment_text'      => $client->getTechnicalPaymentFormText(),
					'quantity_orders'   => $s->orders->count(),

					'document_text'     => $client->short_document,
					'client_text'       => $client->getName(),
					'client_id'         => $client->id,

					'status_icon'       => $s->status_icon,
					'status_color'      => $s->status_color,
					'status_text'       => $s->status_text,
				];
			});

		$closings = Order::where('status', OrderStatusTrait::$_STATUS_FINALIZADA_)
		            ->whereNull('billing_id')
		            ->whereNull('closed_at')
		            ->with('client')
		            ->clients()
		            ->get()
                    ->groupBy('client_id')
                    ->map(function($os){
                    	$s = $os->first();
                    	return [
		                    'client_id'         => $s->client_id,
		                    'client_name'       => $s->client->fantasy_name_text,
		                    'social_reason_text'=> $s->client->social_reason_text,
		                    'short_document'    => $s->client->short_document,
		                    'image'             => $s->client->getThumbFileView(),
		                    'quantity'          => $os->count(),
	                    ];
					});

		$this->page->title         = 'Faturamentos para Clientes';
		$this->page->subtitle      = 'Clientes';
		$this->page->create_option = 0;

		$this->page->response = [
			'closings'    => $closings,
			'billings'    => $billings,
			'cost_center' => false,
		];

		return view('pages.financial.billings.clients.partial')
			->with('Page', $this->page);
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function cost_center()
	{
		$billings = $this->user
			->billings()
			->costCenters()
			->oppened()
			->get()
			->map( function($s) {
				$client = $s->client;
				return [
					'id'                => $s->id,
					'name'              => " #" . $s->id,
					'created_at'        => $s->created_at_formatted,
					'created_at_time'   => $s->created_at_time,

					'payment_text'      => $client->getTechnicalPaymentFormText(),
					'quantity_orders'   => $s->orders->count(),

					'document_text' => $client->short_document,
					'client_text'   => $client->getName(),
					'client_id'     => $client->id,

					'status_icon'       => $s->status_icon,
					'status_color'      => $s->status_color,
					'status_text'       => $s->status_text,

				];
			});

		$closings = Order::where('status', OrderStatusTrait::$_STATUS_FINALIZADA_)
		                 ->whereNull('billing_id')
		                 ->whereNull('closed_at')
		                 ->with('cost_center')
		                 ->costCenters()
		                 ->get()
		                 ->groupBy('cost_center_id')
		                 ->map(function($os){
			                 $s = $os->first();
			                 return [
				                 'client_id'          => $s->cost_center_id,
				                 'client_text'        => $s->cost_center->fantasy_name_text,
				                 'social_reason_text' => $s->cost_center->social_reason_text,
				                 'short_document'     => $s->cost_center->short_document,
				                 'image'              => $s->cost_center->getThumbFileView(),
				                 'quantity'           => $os->count(),
			                 ];
		                 });

		$this->page->response = [
			'closings'    => $closings,
			'billings'    => $billings,
			'cost_center' => true,
		];

		$this->page->title         = 'Faturamentos para Clientes Centro de Custo';
		$this->page->subtitle      = 'Clientes Centro de Custo';
		$this->page->create_option = 0;

		return view( 'pages.financial.billings.clients.partial' )
			->with('Page', $this->page);
	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Financials\Billing $billing
     * @return \Illuminate\Http\Response
     */
    public function show(Billing $billing)
    {
        return view('pages.financial.billings.clients.show')
            ->with('Page', $this->page)
            ->with('Data', $billing);
    }
    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @param int $cost_center
     * @return \Illuminate\Http\Response
     */
    public function showClosing(Client $client, $cost_center)
    {
	    if ( $cost_center ) {
		    $query = $client->orders_cost_center();
	    } else {
		    $query = $client->orders();
	    }

	    $orders = $query->where( 'status', OrderStatusTrait::$_STATUS_FINALIZADA_ )
	                    ->whereNull( 'billing_id' )
	                    ->whereNull( 'billing_id' )
	                    ->whereNull( 'closed_at' )
	                    ->get();

        $values = DataHelper::getVectorKeyFloat2Currency(Billing::getValuesClosing($orders));

        return view('pages.financial.billings.clients.show_closing')
	        ->with('Page', $this->page)
	        ->with('Values', $values)
	        ->with('Client', $client)
	        ->with( 'Orders', $orders )
	        ->with( 'cost_center', $cost_center );

    }

	/**
	 * Set Portion to billing payment.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function setPortion(Request $request)
	{
		$data = Payment::setPayment($request->all());
		return response()->success( 'Parcela recebida com sucesso!', $data, route(  'billings.clients.show', $data->billing ) );
	}

	/**
	 * Destroy the specified resource.
	 *
	 * @param  \App\Models\Financials\Billing $billing
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Billing $billing)
	{
		$message = 'Faturamento ' .  $billing->id . ' reaberto com sucesso!';
		$billing->delete();
		return response()->success( $message, [], route(  'billings.clients.report' ) );
	}

	/**
	 * Close the specified resource.
	 *
	 * @param  \App\Models\Financials\Billing $billing
	 * @return \Illuminate\Http\Response
	 */
	public function close(Billing $billing)
	{
		$billing->close();
		$message = 'Faturamento ' .  $billing->id . ' finalizado com sucesso!';
		return response()->success( $message, $billing, route(  'billings.clients.show', $billing->id ) );
	}
	/**
	 * Display a listing of the resource.
     * @param Client $client
     * @param int $cost_center
	 * @return \Illuminate\Http\Response
	 */
	public function bill(Client $client, $cost_center = 0)
	{

		if ( $cost_center ) {
			$query = $client->orders_cost_center();
		} else {
			$query = $client->orders();
		}

		$orders = $query
			->where( 'status', OrderStatusTrait::$_STATUS_FINALIZADA_ )
			->whereNull( 'billing_id' )
			->whereNull( 'billing_id' )
			->whereNull( 'closed_at' )
			->get();

        //FECHANDO O.S. PARA FATURAR
        $billing = Billing::generateBill($orders, $cost_center);

        $message = 'Faturamento ' .  $billing->id . ' aberto com sucesso!';
        return response()->success( $message, $billing, route(  'billings.clients.show', $billing->id ) );







	    return $Billing;
		$request->merge(['situacao' => OrdemServico::_STATUS_FINALIZADA_]);
		$request->merge(['centro_custo' => $centro_custo]);
		$query = OrdemServico::filter_layout($request->all())
		                     ->whereNull('idfaturamento');
//        $query->update(['data_fechada', Carbon::now()]);

		if ($request->get('centro_custo')) {
			$query = $query->where('idcentro_custo', $id);
		} else {
			$query = $query->where('idcliente', $id);
		}

		$OrdemServicos = $query->get();

		//FECHANDO O.S. PARA FATURAR
//        foreach ($OrdemServicos as $ordem_servico) {
//            $ordem_servico->fechar();
//        }

		$Faturamento = Faturamento::geraFaturamento($OrdemServicos, $request->get('centro_custo'));

		session()->forget('mensagem');
		session(['mensagem' => $this->Page->msg_abr]);
		return Redirect::route('faturamentos.show', $Faturamento->id);
	}
//
//
//	public function faturar_pos(Request $request, $centro_custo, $id)
//	{
//		$request->merge(['situacao' => OrdemServico::_STATUS_FATURAMENTO_PENDENTE_]);
//		$request->merge(['centro_custo' => $centro_custo]);
//		$query = OrdemServico::filter_layout($request->all())
//		                     ->whereNull('idfaturamento');
//
//		if ($request->get('centro_custo')) {
//			$query = $query->where('idcentro_custo', $id);
//			$OrdemServicos = $query->get();
//		} else {
//			$OrdemServicos = $query->where('idcliente', $id)->get();
//		}
//
//		$Faturamento = Faturamento::geraFaturamento($OrdemServicos, $request->get('centro_custo'));
//
//		session()->forget('mensagem');
//		session(['mensagem' => $this->Page->msg_abr]);
//		return Redirect::route('faturamentos.show', $Faturamento->id);
//	}
//
//	public function runByOrdemServicoID($id = NULL)
//	{
//		if ($id == NULL) return $id;
//		$OrdemServicos = OrdemServico::find($id);
//
//		$centro_custo = ($OrdemServicos->idcentro_custo != NULL);
//		Faturamento::geraFaturamento($OrdemServicos, $centro_custo);
//		session()->forget('mensagem');
//		session(['mensagem' => $this->Page->msg_abr]);
//		return Redirect::route($this->Page->link . '.index', 'todas');
//	}
//
//	public function run()
//	{
//		$DATA_INICIO = Carbon::parse('first day of last month')->format('Y-m-d 00:00:00');//'2017-01-01 00:00:00' (1º dia do mês anterior)
//		$DATA_FIM = Carbon::parse('last day of last month')->format('Y-m-d 23:59:59');// '2017-01-31 23:59:59' (1º dia do mês vigente)
//		$OrdemServicos = OrdemServico::whereBetween('data_finalizada', [$DATA_INICIO, $DATA_FIM])
//		                             ->whereNull('idfaturamento')
//		                             ->orderBy('idcentro_custo', 'desc')
//		                             ->get();
////            ->get(['idordem_servico','idcentro_custo','idcliente']);
//		return Faturamento::faturaPeriodo($OrdemServicos);
//	}
//
//
//	// ============= /NF ==================
//
//
//	/**
//	 * Display the specified resource.
//	 *
//	 * @param  int $id
//	 * @return \Illuminate\Http\Response
//	 */
//	public function show_values($id)
//	{
//		$Faturamento = Faturamento::find($id);
//		return $Faturamento->getAllPecas();
//	}

}
