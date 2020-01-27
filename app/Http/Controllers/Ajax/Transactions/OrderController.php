<?php

namespace App\Http\Controllers\Ajax\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\Apparatu;
use App\Models\Transactions\Order;
use App\Models\Transactions\Settings\ApparatuPart;
use App\Models\Transactions\Settings\ApparatuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Values of an Order.
     * @param \App\Models\Transactions\Order $order
     * @return array
     */
    public function values(Order $order)
    {
    	return $order->getResumedValuesArray();
    }

	/**
	 * Show an Input(Service/Part) to an Order Apparatu .
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Transactions\Apparatu $apparatu
	 * @return array
	 */
	public function showInput(Request $request, Apparatu $apparatu)
	{
//		VERIFICAR SE SERVIÇO EXISTE
		if($request->get('input')=='service'){
			if($data = $apparatu->apparatu_service($request->get('id'))){
				$data = [
					'id'                    => $data->id,
					'service_id'            => $data->service_id,
					'name'                  => $data->parent_name,
					'value'                 => $data->value,
					'value_formatted'       => $data->value_formatted,
					'quantity'              => $data->quantity,
					'discount'              => $data->discount,
					'discount_formatted'    => $data->discount_formatted,
					'total'                 => $data->total,
					'total_formatted'       => $data->total_formatted,
				];
				return response()->success( trans( 'messages.crud.MDTS',['name'=>'Serviço'] ), $data, '' );
			} else {
				$error = trans( 'messages.crud.MDTE', ['name'=>'Serviço']);
			}
		} else {
			if($data = $apparatu->apparatu_part($request->get('id'))){
				$data = [
					'id'                    => $data->id,
					'part_id'               => $data->part_id,
					'name'                  => $data->parent_name,
					'value'                 => $data->value,
					'value_formatted'       => $data->value_formatted,
					'quantity'              => $data->quantity,
					'discount'              => $data->discount,
					'discount_formatted'    => $data->discount_formatted,
					'total'                 => $data->total,
					'total_formatted'       => $data->total_formatted,
				];
				return response()->success( trans( 'messages.crud.FDTS',['name'=>'Peça'] ), $data, '' );
			} else {
				$error = trans( 'messages.crud.FDTE', ['name'=>'Peça']);
			}
		}
		return $this->error(  $error );
	}
	/**
	 * Add an Input(Service/Part) to an Order Apparatu .
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Transactions\Apparatu $apparatu
	 * @return array
	 */
	public function addInput(Request $request, Apparatu $apparatu)
	{
		if($request->get('input')=='service'){
	//		VERIFICAR SE SERVIÇO JÁ FOI ADICIONADO
			if($apparatu->checkServiceExists($request->get('id'))){
				// SE SIM, RETORNAR ERRO DE SERVIÇO JÁ ADICIONADO
				$error =  trans( 'messages.crud.M.ADD.DUPLICATE', ['name'=>'Serviço']);

			} else {
				// SE NÃO, AADICIONAR SERVIÇO AO APPARATU E ATUALIZAR VALORES DA O.S
				$data = $apparatu->addService($request->all());
				return response()->success( trans( 'messages.crud.M.ADD.SUCCESS',['name'=>'Serviço ' . $data['name']] ), $data, '' );
			}
		} else {
			if($apparatu->checkPartExists($request->get('id'))){
				// SE SIM, RETORNAR ERRO DE SERVIÇO JÁ ADICIONADO
				$error = trans( 'messages.crud.F.ADD.DUPLICATE', ['name'=>'Peça']);

			} else {
				// SE NÃO, AADICIONAR SERVIÇO AO APPARATU E ATUALIZAR VALORES DA O.S
				$data = $apparatu->addPart($request->all());
				return response()->success( trans( 'messages.crud.F.ADD.SUCCESS',['name'=>'Peça ' . $data['name']] ), $data, '' );
			}
		}


		return $this->error(  $error );
	}

	/**
	 * Remove an Input(Service/Part) to an Order Apparatu .
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Transactions\Apparatu $apparatu
	 * @return array
	 */
	public function removeInput(Request $request, Apparatu $apparatu)
	{
		if($request->get('input')=='service'){
//		VERIFICAR SE SERVIÇO JÁ FOI REMOVIDO
			if(!$apparatu->checkServiceExists($request->get('input_id'))){
				// SE SIM, RETORNAR ERRO DE SERVIÇO JÁ REMOVIDO
				$error = trans( 'messages.crud.M.DELETE.ERROR', ['name'=>'Serviço']);

			} else {
				// SE NÃO, AADICIONAR SERVIÇO AO APPARATU E ATUALIZAR VALORES DA O.S
				$data = $apparatu->remService($request->get('id'));
				return response()->success( trans( 'messages.crud.M.DELETE.SUCCESS',['name'=>'Serviço'] ), $data, '' );
			}
		} else {
			if(!$apparatu->checkPartExists($request->get('input_id'))){
				// SE SIM, RETORNAR ERRO DE SERVIÇO JÁ REMOVIDO
				$error = trans( 'messages.crud.F.DELETE.ERROR', ['name'=>'Part']);

			} else {
				// SE NÃO, AADICIONAR SERVIÇO AO APPARATU E ATUALIZAR VALORES DA O.S
				$data = $apparatu->remPart($request->get('id'));
				return response()->success( trans( 'messages.crud.F.DELETE.SUCCESS',['name'=>'Peça'] ), $data, '' );
			}
		}
		return $this->error(  $error );
	}

	/**
	 * Save an Input(Service/Part) to an Order Apparatu .
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	public function saveInput(Request $request)
	{
		//MELHORAR
		if($request->get('input')=='service'){
			$data = ApparatuService::find($request->get('id'));

	//		VERIFICAR SE SERVIÇO EXISTE
			if($data->exists()){
				$data->update($request->all());
				$data = [
						'id'                    => $data->id,
						'service_id'            => $data->service_id,
						'name'                  => $data->parent_name,
						'value'                 => $data->value,
						'value_formatted'       => $data->value_formatted,
						'quantity'              => $data->quantity,
						'discount'              => $data->discount,
						'discount_formatted'    => $data->discount_formatted,
						'total'                 => $data->total,
						'total_formatted'       => $data->total_formatted,
				];
				return response()->success( trans( 'messages.crud.M.UPDATE.SUCCESS',['name'=>'Serviço ' . $data['name']] ), $data, '' );
			} else {
				$error = trans( 'messages.crud.M.UPDATE.ERROR', ['name'=>'Serviço']);
			}
		} else {
			$data = ApparatuPart::find($request->get('id'));

			//		VERIFICAR SE SERVIÇO EXISTE
			if($data->exists()){
				$data->update($request->all());
				$data = [
					'id'                    => $data->id,
					'part_id'               => $data->part_id,
					'name'                  => $data->parent_name,
					'value'                 => $data->value,
					'value_formatted'       => $data->value_formatted,
					'quantity'              => $data->quantity,
					'discount'              => $data->discount,
					'discount_formatted'    => $data->discount_formatted,
					'total'                 => $data->total,
					'total_formatted'       => $data->total_formatted,
				];
				return response()->success( trans( 'messages.crud.F.UPDATE.SUCCESS',['name'=>'Peça ' . $data['name']] ), $data, '' );
			} else {
				$error =  trans( 'messages.crud.F.UPDATE.ERROR', ['name'=>'Peça']);
			}
		}
		return $this->error( $error  );
	}

	/**
	 * Remove an an Order Apparatu .
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Transactions\Order $order
	 * @return array
	 */
	public function removeApparatu(Request $request, Order $order)
	{
//		VERIFICAR SE SERVIÇO JÁ FOI REMOVIDO
		if(!$order->checkApparatuExists($request->get('id'))){
			// SE SIM, RETORNAR ERRO DE SERVIÇO JÁ REMOVIDO
			return $this->error(  trans( 'messages.crud.M.DELETE.ERROR', ['name'=>'Equipamento']) );

		} else {
			// SE NÃO, AADICIONAR SERVIÇO AO APPARATU E ATUALIZAR VALORES DA O.S
			$data = $order->remApparatu($request->get('id'));
			return response()->success( trans( 'messages.crud.M.DELETE.SUCCESS',['name'=>'Equipamento'] ), $data, '' );
		}
	}

}
