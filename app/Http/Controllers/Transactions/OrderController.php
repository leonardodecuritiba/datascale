<?php

namespace App\Http\Controllers\Transactions;

use App\Filters\ClientFilter;
use App\Filters\OrderFilter;
use App\Helpers\DataHelper;
use App\Helpers\PrintHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\OrderFinishRequest;
use App\Http\Requests\Transactions\OrderRequest;
use App\Models\HumanResources\Client;
use App\Models\Parts\Part;
use App\Models\Parts\Service;
use App\Models\Transactions\Order;
use App\Models\Transactions\Settings\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{

//return config('variables.cfop.' . $this->getAttribute('cfop'));
	public $entity = "orders";
	public $sex = "F";
	public $name = "Ordem de Serviço";
	public $names = "Ordens de Serviço";
	public $main_folder = 'pages.transactions.orders';
	public $page = [];
	public $ClientFilter;
	public $OrderFilter;

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
		$this->ClientFilter = new ClientFilter();
		$this->OrderFilter = new OrderFilter();
	}


    /**
     * Display a listing of the Orders.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
	    $this->page->auxiliar = [
		    'clients' => Client::getAlltoSelectList(),
		    'status'  => OrderStatus::getAlltoSelectList(),
	    ];

	    $orders = $this->user->orders();
	    $this->page->response = $this->OrderFilter->map( $request, $orders );


//	    dd($this->page->response['past_orders']);
//
//	    foreach ( $this->page->response['past_orders'] as $period => $orders ) {
//		    echo $period . "<br>";
//		    echo $orders->count() . "<br>";
//	    }
//	    exit;
//	    return $this->page->response;




	    $this->page->create_option = 1;
        return view('pages.transactions.technical_operations.orders.index' )
            ->with( 'Page', $this->page );
    }

	/**
	 * Show an Order.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$clients = $this->user->clients();
		$this->page->response = $this->ClientFilter->map($request, $clients);
		return view('pages.transactions.technical_operations.orders.create' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show an Order.
	 * @param \App\Models\Transactions\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function show(Order $order)
	{
//		return $order->apparatus->first()->getNumberSealsUnSetted();
		if($order->isClosed()){
			return Redirect::route('transactions.orders.resume', $order);
		}
		$price_id = $order->client->technical_price_id;
		$this->page->auxiliar = [
			'services'  => Service::client_prices($price_id),
			'parts'     => Part::client_prices($price_id),
		];

		return view('pages.transactions.technical_operations.orders.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $order );
    }


	/**
	 * Show an Order.
	 * @param $idordem_servico
	 * @return Redirect
	 */
	public function oldShow($idordem_servico)
	{
		$order = Order::where( 'idordem_servico', $idordem_servico )->first();
		return Redirect::route('orders.show', $order);
	}

	/**
     * Show resumed Order.
	 * @param \App\Models\Transactions\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function resume(Order $order)
	{
		return view('pages.transactions.technical_operations.orders.resume' )
			->with( 'Page', $this->page )
			->with( 'Data', $order );
    }

	/**
	 * Open new Order.
     * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function open(Request $request)
	{
        $client = Client::find($request->get('client_id'));
        //verify if is over client technical limit
        $limit = $client->getAvailableLimit('technical');
        if($limit <= 0){
			$value = DataHelper::getFloat2Currency($limit);
			$message = trans('orders.bellow_limit',['value'=>$value]);
			return response()->error( [$message] );
		} else if ($client->isValidated()) {
			$data = Order::open($client);
			return response()->success( trans('orders.opened'), $data, route( 'orders.show', $data->id ) );
		} else {
			$message = trans('orders.client_not_validated');
			return response()->error( [$message] );
		}
	}


	/**
	 * Finish Order.
	 * @param \App\Http\Requests\Transactions\OrderFinishRequest $request
	 * @param \App\Models\Transactions\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function finish(OrderFinishRequest $request, Order $order)
	{
		$os_value = $order->getAttribute('final_value');
		$limit = $order->client->getAvailableLimit('technical');
		//verify if is over client technical limit
		if($os_value > $limit){
			$limit = DataHelper::getFloat2Currency($limit);
			$final_value = DataHelper::getFloat2Currency($os_value);
			$message = trans('orders.finish_bellow_limit',['final_value'=>$final_value,'limit'=>$limit]);
			return response()->error( [$message] );
		}

		$order->finish($request->all());
		return response()->success( trans('orders.finished'), $order, route( 'orders.show', $order->id ) );
	}

	/**
	 * Reopen Order.
	 * @param \App\Models\Transactions\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function reopen(Order $order)
	{
		$order->reopen();
		return response()->success( trans('orders.reopened'), $order, route( 'orders.show', $order->id ) );
	}

    /**
     * Print Order.
     * @param \App\Models\Transactions\Order $order
     * @return \Illuminate\Http\Response
     */
    public function print(Order $order)
    {
        $PrintHelper = new PrintHelper();
        return $PrintHelper->printOS($order);
    }

	/**
	 * Export Order.
	 * @param \App\Models\Transactions\Order $order
	 * @return \Illuminate\Http\Response
	 */
    public function export(Order $order)
    {
        $PrintHelper = new PrintHelper();
        return $PrintHelper->exportOS($order);
    }

	/**
	 * Send Order by email.
	 * @param \App\Models\Transactions\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function send(Order $order)
	{
		return 'encaminhar por email';
		$OrdemServico = OrdemServico::find($idordem_servico);
		$OrdemServico->update([
			'data_finalizada' => Carbon::now()->toDateTimeString()
		]);
		session()->forget('mensagem');
		session(['mensagem' => $this->Page->msg_fec]);
		return $this->resumo($request, $idordem_servico);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Transactions\Order $order
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(Order $order)
	{
		$message = 'Ordem de Serviço #' .  $order->id . ' excluída com sucesso!';
		$order->delete();
		return response()->success( $message, [], route(  'orders.index' ) );
	}
}
