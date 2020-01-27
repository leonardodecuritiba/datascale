<?php

namespace App\Traits\Orders;

use App\Models\HumanResources\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait OrderFlowTrait {

    static public function open(Client $client)
    {
        $data = [
            'client_id'         => $client->id,
            'user_id'           => Auth::id(),
            'cost_center_id'    => $client->cost_center_id,
            'travel_cost'       => $client->getTotalTravelCost(),
            'tolls'             => is_null($client->tolls) ? 0 : $client->tolls,
            'other_cost'        => is_null($client->other_cost) ? 0 : $client->other_cost,
            'total_value'       => 0,
            'status'            => self::$_STATUS_ABERTA_

        ];
        return self::create($data);
    }

    public function finish(array $request)
    {
        if (isset($request['exemption_cost'])) {
            $custos = $this->attributes['travel_cost'] + $this->attributes['tolls'] + $this->attributes['other_cost'];
            $this->attributes['travel_cost'] = 0;
            $this->attributes['tolls'] = 0;
            $this->attributes['other_cost'] = 0;
            $this->attributes['final_value'] = $this->attributes['final_value'] - $custos;
            $this->attributes['exemption_cost'] = 1;
//            $this->update_valores();
        }
//        $this->attributes['numero_chamado'] = $request['numero_chamado'];
        $this->attributes['responsible'] = $request['responsible'];
        $this->attributes['responsible_cpf'] = $request['responsible_cpf'];
        $this->attributes['responsible_position'] = $request['responsible_position'];
        $this->attributes['finished_at'] = Carbon::now()->toDateTimeString();
        $this->attributes['status'] = self::$_STATUS_FINALIZADA_;
        return $this->save();
    }

    public function reopen()
    {
        $this->update([
            'finished_at'   => NULL,
            'closed_at'     => NULL,
            'status'        => self::$_STATUS_ABERTA_,
        ]);
        return true;
    }

    public function setBilling($billing_id)
    {
        $this->attributes['billing_id'] = $billing_id;
        $this->attributes['status'] = self::$_STATUS_FATURADA_;
        return $this->save();
    }


//    public function fechar()
//    {
//        $this->attributes['data_fechada'] = Carbon::now()->toDateTimeString();
//        $this->attributes['idsituacao_ordem_servico'] = self::_STATUS_FATURAMENTO_PENDENTE_;
//        return $this->save();
//    }
//


}