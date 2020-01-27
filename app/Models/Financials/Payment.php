<?php

namespace App\Models\Financials;

use App\Traits\DateTimeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    const _STATUS_PAGO_ = 1;
    const _STATUS_PENDENTE_ = 0; //danger
    use SoftDeletes;
    use DateTimeTrait;
    public $timestamps = true;

    protected $fillable = [
        'idpagamentos',
        'set_date',
        'status',
    ];

    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================

    static public function setPayment($data)
    {
        $Portion = Portion::set($data);
        $Payment = $Portion->payment;
        if ($Payment->pendent_portions()->count() == 0) {
            $Payment->set_date = $Portion->setted_at;
            $Payment->status = 1;
            $Payment->save();
            $Payment->billing->bill();
        }
        return $Payment;
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

	//======================== FUNCTIONS =========================

	public function pendent_portions() //getParcelasPendentes
	{
		return $this->portions()->pendents();
	}

	public function received_portions() //getParcelasPagas
	{
		return $this->portions()->receiveds();
	}

    //======================== BELONGS ===========================


    //======================== HASONE ============================
    public function billing()
    {
        return $this->hasOne(Billing::class, 'payment_id');
    }

    //======================== HASMANY ===========================
    public function portions()
    {
        return $this->hasMany(Portion::class, 'payment_id');
    }
}
