<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\ApparatuRequest;
use App\Models\Transactions\Apparatu;
use App\Models\Transactions\Order;
use Illuminate\Http\Request;

class ApparatuController extends Controller
{
	public function update(ApparatuRequest $request, $apparatu_id)
	{
//	    return $request->all();

	    //VERIFICAR SE REALMENTE FAZ PARTE DA ORDEM EM QUESTÃO (a fazer)
		$Apparatu = Apparatu::findOrFail($apparatu_id);

		$Apparatu->update($request->only(['defect','solution']));

		//Atualizando a situação da O.S
		if($Apparatu->order->status != Order::$_STATUS_ATENDIMENTO_EM_ANDAMENTO_){
			$Apparatu->order->update( [
				'status' => Order::$_STATUS_ATENDIMENTO_EM_ANDAMENTO_
			]);
		}

		if ($Apparatu->has_instrument()) {
			$Apparatu->updateLabelSealInstrument( $request->all());
			$msg = trans('orders.instrument_updated');
		} else {
			$msg = trans('orders.equipment_updated');
		}

		return response()->success( $msg, $Apparatu->order, route( 'orders.show', $Apparatu->order_id ) );
	}


    /**
     * Add new Apparatu to Order.
     * @param \Illuminate\Http\Request $request
     * @param $order_id
     * @return \Illuminate\Http\Response
     */
    public function addApparatu(Request $request, $order_id)
    {
        //teste se já foi adicionado
        if($request->get('type') == 'equipment'){
            $equipment_id = $request->get('id');
            if (Apparatu::checkDoubleEquipment($order_id, $equipment_id)) {
                $message = trans('orders.double_equipment');
                return response()->error( [$message] );
            } else {
                $data = Apparatu::create([
                    'order_id'      => $order_id,
                    'equipment_id'  => $equipment_id,
                    'call_number'   => $request->get('call_number')
                ]);
                return response()->success( trans('orders.equipment_added'), $data, route( 'orders.show', $order_id ) );
            }
        } else {
            $instrument_id = $request->get('id');
            if (Apparatu::checkDoubleInstrument($order_id, $instrument_id)) {
                $message = trans('orders.double_instrument');
                return response()->error( [$message] );
            } else {
                $data = Apparatu::create([
                    'order_id'      => $order_id,
                    'instrument_id' => $instrument_id,
                    'call_number'   => $request->get('call_number')
                ]);
                return response()->success( trans('orders.instrument_added'), $data, route( 'orders.show', $order_id ) );
            }
        }
    }
}
