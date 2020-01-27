<?php

namespace App\Traits\Orders;


use App\Models\Transactions\Order;
use App\Models\Transactions\Settings\OrderStatus;

trait OrderStatusTrait {

    static $_STATUS_ABERTA_ = 1;
    static $_STATUS_ATENDIMENTO_EM_ANDAMENTO_ = 2;
    static $_STATUS_FINALIZADA_ = 3;
    static $_STATUS_AGUARDANDO_PECA_ = 4;
    static $_STATUS_EQUIPAMENTO_NA_OFICINA_ = 5; //primary
    static $_STATUS_FATURADA_ = 6; //success
    static $_STATUS_FATURAMENTO_PENDENTE_ = 7; //success

    public function getStatusColorAttribute()
    {
        switch ($this->getAttribute('status')){
            case self::$_STATUS_ABERTA_:
                return 'info';
            case self::$_STATUS_ATENDIMENTO_EM_ANDAMENTO_:
                return 'warning';
            case self::$_STATUS_FINALIZADA_:
                return 'danger';
            case self::$_STATUS_AGUARDANDO_PECA_:
                return 'warning';
            case self::$_STATUS_EQUIPAMENTO_NA_OFICINA_:
                return 'warning';
            case self::$_STATUS_FATURADA_:
                return 'success';
            case self::$_STATUS_FATURAMENTO_PENDENTE_:
                return 'warning';
        }
    }

    public function getStatusIconAttribute()
    {
        switch ($this->getAttribute('status')){
            case self::$_STATUS_ABERTA_:
                return 'info';
            case self::$_STATUS_ATENDIMENTO_EM_ANDAMENTO_:
                return 'compare_arrows';
            case self::$_STATUS_FINALIZADA_:
                return 'done';
            case self::$_STATUS_AGUARDANDO_PECA_:
                return 'autorenew';
            case self::$_STATUS_EQUIPAMENTO_NA_OFICINA_:
                return 'warning';
            case self::$_STATUS_FATURADA_:
                return 'done_all';
            case self::$_STATUS_FATURAMENTO_PENDENTE_:
                return 'report_problem';
        }
    }

    public function getStatusTextAttribute()
    {
        return OrderStatus::whereId($this->getAttribute('status'))->description;
    }


    public function isClosed() //RETORNA O STATUS 0:ABERTA 1:FECHADA
    {
        return (
            ($this->getAttribute('finished_at') != NULL)
            &&
            (
                ($this->getAttribute('status') == self::$_STATUS_FINALIZADA_)
                ||
                ($this->getAttribute('status') == self::$_STATUS_FATURADA_)
                ||
                ($this->getAttribute('status') == self::$_STATUS_FATURAMENTO_PENDENTE_)
//                ($this->getAttribute('status') == self::_STATUS_A_FATURAR_)

            )
        ) ? 1 : 0;
    }

}