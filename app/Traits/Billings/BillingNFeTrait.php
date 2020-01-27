<?php

namespace App\Traits\Billings;


use App\Models\Commons\Setting;
use App\Models\Financials\Fiscals\NF;
use App\Models\Financials\Fiscals\NFe;
use App\Models\Financials\Fiscals\NFSe;
use Carbon\Carbon;

trait BillingNFeTrait {

    //====================== NF ===========================

	public function getNF($debug, $type)
	{
		$ref = ($debug) ? $this->{ $type . '_id_homologacao' } : $this->{ $type . '_id_producao'};
		return ($ref == NULL) ? $ref : json_encode(NF::get($ref, $debug, $type));
	}


	public function sendNF($debug, $type)
	{
		$option = ($debug) ? 'homologacao' : 'producao';
		$ref_index = Setting::getByMetaKey('ref_' . $type . 'index_' . $option);
		$this->update([
			$type . '_id_' . $option => $ref_index->meta_value,
			$type . '_date_' . $option => Carbon::now()->toDateTimeString()
		]);
		$ref_index->_increment();
		return $this->setNF($debug, $type);
	}

	public function setNF($debug, $type)
	{
		if (!strcmp($type, 'nfe')) {
			$NF = new NFe($debug, $this);
		} else {
			$NF = new NFSe($debug, $this);
		}

		$retorno = $NF->send();


		if (isset($retorno->body->erros)) {
			$responseNF = [
				'message' => $retorno->body->erros,
				'code' => $retorno->result,
				'error' => 1,
			];
		} else if($retorno->result>400){
			$responseNF = [
				'message' => $retorno->body,
				'code' => $retorno->result,
				'error' => 1,
			];
		} else {
			$responseNF = [
				'message' => 'Nota Fiscal (Ref. #' . $NF->_REF_ . ') enviada com sucesso! Aguarde para consultá-la.',
				'code' => $retorno->result,
				'error' => 0,
			];
		}

		return $responseNF;
	}

	public function cancelNF($debug, $type, $data)
	{
		$debug = ($debug) ? 'homologacao' : 'producao';
		$ref_key = $type . '_id_' . $debug;
		return NF::cancel($this->{$ref_key}, $debug, $type, $data);
		return $message = 'Nota Fiscal enviada para cancelamento com sucesso! Aguarde para consultá-la.';
	}

	public function sendNfByEmail($link)
	{
		return $this->client->sendNF($link);
	}

	public function resendNF($debug, $type)
	{
		return $this->setNF($debug, $type);
	}
}