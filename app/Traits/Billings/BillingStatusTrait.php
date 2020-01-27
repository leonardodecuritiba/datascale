<?php

namespace App\Traits\Billings;


use App\Models\Financials\Settings\BillingStatus;

trait BillingStatusTrait {

    static $_STATUS_ABERTA_ = 1;
    static $_STATUS_FINALIZADO_ = 2;
    static $_STATUS_QUITADO_ = 3;

    public function getStatusColorAttribute()
    {
        switch ($this->getAttribute('status')){
            case self::$_STATUS_ABERTA_:
                return 'warning';
            case self::$_STATUS_FINALIZADO_:
                return 'danger';
            case self::$_STATUS_QUITADO_:
                return 'success';
        }
    }

    public function getStatusIconAttribute()
    {
        switch ($this->getAttribute('status')){
            case self::$_STATUS_ABERTA_:
                return 'info';
            case self::$_STATUS_FINALIZADO_:
                return 'compare_arrows';
            case self::$_STATUS_QUITADO_:
                return 'done';
        }
    }

    public function getStatusTextAttribute()
    {
        return BillingStatus::whereId($this->getAttribute('status'))->description;
    }

//    public function isAberto()
//    {
//        return ($this->attributes['idstatus_faturamento'] == self::_STATUS_ABERTO_);
//    }


}