<?php

namespace App\Traits\Billings;

use App\Models\Financials\Payment;
use App\Models\Financials\Portion;
use App\Models\Financials\Settings\PaymentDue;
use Illuminate\Support\Collection;
use Zizaco\Entrust\EntrustFacade;

trait BillingFlowTrait {

    public function canShowDeleteBtn()
    {
        return EntrustFacade::hasRole(['admin', 'root']);
    }

    public function canShowFinishBtn()
    {
	    return ($this->getAttribute('status') == BillingStatusTrait::$_STATUS_ABERTA_);
    }

    public function canShowNFBtn()
    {
	    return 1;
    }

    public function canShowGenerateHomologationNFeBtn()
    {
        return ($this->attributes['nfe_id_homologacao'] == NULL);
    }

	public function canShowViewHomologationNFeBtn()
	{
		return !$this->canShowGenerateHomologationNFeBtn();
	}

	public function canShowGenerateNFeBtn()
	{
		return ($this->attributes['nfe_id_producao'] == NULL) && ( $this->canShowViewHomologationNFeBtn());
	}

    public function canShowViewNFeBtn()
    {
	    return ($this->attributes['nfe_id_producao'] != NULL);
    }



    public function canShowGenerateHomologationNFSeBtn()
    {
	    return ($this->attributes['nfse_id_homologacao'] == NULL);
    }

	public function canShowViewHomologationNFSeBtn()
	{
		return !$this->canShowGenerateHomologationNFSeBtn();
	}

	public function canShowGenerateNFSeBtn()
	{
		return ($this->attributes['nfse_id_producao'] == NULL) && ( $this->canShowViewHomologationNFSeBtn());
	}

    public function canShowViewNFSeBtn()
    {
	    return ($this->attributes['nfse_id_producao'] != NULL);
    }





//    static public function geraFaturamento($OrdemServicos, $centro_custo = 0, $arr = 0)

    static public function generateBill(Collection $Orders, $cost_center = 0, $arr = 0)
    {
        if ($arr == 1) {
            $client = ($cost_center) ? $Orders[0]->cost_center : $Orders[0]->client;
        } else {
            $client = ($cost_center) ? $Orders->first()->cost_center : $Orders->first()->client;
        }
        if ($client->verifyTechnicalDuePayment(PaymentDue::_STATUS_A_VISTA_)) {
            $data_portions = ['quantity' => 1, 'due' => 0];
        } else {
            $temp = $client->getTechnicalDuePaymentExtras();
            $data_portions = ['quantity' => count($temp), 'due' => $temp];
        }


	    //CRIAR PAGAMENTO
        $Payment = Payment::create();

        //ATRIBUIR IDPAGAMENTO AO FECHAMENTO
        $Billing = self::create([
            'client_id'             => $client->id,
            'status'                => self::$_STATUS_ABERTA_,
            'payment_id'            => $Payment->id,
            'cost_center'           => $cost_center,
        ]);

        //SETAR ORDEM SERVIÇOS COMO FATURADAS
        if (isset($Orders->id)) {
            $Orders->setBilling($Billing->id);
        } else {
            foreach ($Orders as $order) {
                $order->setBilling($Billing->id);
            }
        }

        //DEFINIR AS PARCELAS
        $Valores = $Billing->getValues();
        $data = [
            'payment_id'    => $Payment->id,
            'payment_form'  => $client->technical_form_payment_id,
            'portion_value' => $Valores['final_value'] / $data_portions['quantity'],
        ];
        Portion::setPortions($data, $data_portions);

        return $Billing;
    }

}