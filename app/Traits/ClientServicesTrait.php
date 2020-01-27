<?php

namespace App\Traits;

use App\Helpers\DataHelper;
use App\Models\Transactions\Order;
use Carbon\Carbon;
use Symfony\Component\VarDumper\Cloner\Data;

trait ClientServicesTrait {

    //MELHORAR ESSA FUNÇÃO CORRIGINDO VALIDAÇÃO COM REGRAS
	public function isValidated()
	{
        return true;
		if ($this->getAttribute('validated_at') == NULL) {
			$days = Carbon::now()->diffInHours(Carbon::createFromFormat('Y-m-d H:i:s', $this->getAttribute('created_at')));
			return ($days <= 24);
		}
		return true;
	}

	//MELHORAR ESSA FUNÇÃO USANDO DB
	public function getAvailableLimit($type = 'technical')
	{
		$limit = $this->getAttribute($type . '_credit_limit');
		if($type == 'technical'){
			$os = $this->orders->whereIn('status',                [
				Order::$_STATUS_FINALIZADA_,
				Order::$_STATUS_AGUARDANDO_PECA_,
				Order::$_STATUS_EQUIPAMENTO_NA_OFICINA_,
				Order::$_STATUS_FATURAMENTO_PENDENTE_,
			]);
			$sum = $os->sum('final_value');
		} else {
			$sum = 0;
		}
		return $limit - $sum;
	}

	public function getAvailableLimitCurrency($type = 'technical')
	{
	    return DataHelper::getFloat2Currency($this->getAvailableLimit($type));
	}

	public function getAvailableLimitCurrencyHtml($type = 'technical')
	{
	    $value = $this->getAvailableLimit($type);
	    $data = DataHelper::getFloat2Currency($value);
	    return ($value > 0) ? '<b class="text-success">' . $data . '</b>' :  '<b class="text-danger">' . $data . '</b>';
	}

}