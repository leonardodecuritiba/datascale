<?php

namespace App\Traits\Requests;


use App\Models\Inputs\Settings\Label;
use App\Models\Inputs\Settings\Seal;
use App\Models\Requests\Settings\RequestType;
use App\Models\Requests\Settings\PatternModel;

trait RequestFlowTrait {


	/*
	 * ========================================================
	 * DEFAULT ================================================
	 * ========================================================
	 */

	static public function accept($data)
	{
		$Data = self::findOrFail($data['id']);
		$parameters = $Data->getParametersDecoded();
		$quantity = $parameters->quantidade;
		$data['user_id'] = $Data->requester_id;

		switch($Data->getAttribute('type')){
			case RequestType::_TYPE_PARTS_:
				$parameters->values = $parameters->id;
				break;
			case RequestType::_TYPE_LABELS_:
				$data['values'] = array_slice($data['values'], 0, $quantity); //limitando quantidade
				$parameters->values = $data['values'];
				Label::assign($data);
				break;
			case RequestType::_TYPE_SEALS_:
				$data['values'] = array_slice($data['values'], 0, $quantity); //limitando quantidade
				$parameters->values = $data['values'];
				Seal::assign($data);
				break;
		}

		$Data->update([
			'parameters'    => json_encode($parameters),
			'manager_id'    => $data['manager_id'],
			'status'        => PatternModel::_STATUS_ACEITA_,
		]);
		return $Data;
	}

	static public function deny($data)
	{
		$Data = self::findOrFail($data['id']);
		$Data->update([
			'status'        => PatternModel::_STATUS_NEGADA_,
			'manager_id'    => $data['manager_id'],
			'response'      => $data['response'],
		]);
		return $Data;
	}


	/*
	 * ========================================================
	 * SELO-LACRE =============================================
	 * ========================================================
	 */

	static public function openLabelSealRequest($data)
	{
		$requester_id = $data['requester_id'];
		$parameters = $data['parameters'];

		return self::create( [
//		return ([
			'type'         => ( $data['type'] == 'labels' ) ? RequestType::_TYPE_LABELS_ : RequestType::_TYPE_SEALS_,
			'status'       => PatternModel::_STATUS_AGUARDANDO_,
			'reason'       => $data['reason'],
			'parameters'   => json_encode( [
				"opcao"      => ( $data['type'] == 'labels' ) ? 'selos' : 'lacres',
				"quantidade" => $parameters
			] ),
			'requester_id' => $requester_id,
		]);
	}

	static public function sendSeloLacreRequest($data)
	{
		$Data = self::accept($data);
		$data['user_id'] = $Data->requester->id;
		if ($Data->type == RequestType::_TYPE_SELOS_) {
			Label::assign($data);
		} elseif ($Data->type == RequestType::_TYPE_LACRES_) {
			Seal::assign($data);
		}
		return $Data;
//		return "Requisição aceita com sucesso!";
	}

//	/*
//	 * ========================================================
//	 * PARTS ==================================================
//	 * ========================================================
//	 */
//	static public function openPartsRequest($data)
//	{
//		//openPecasRequest
//		$idrequester = $data['idrequester'];
//		$parameters = $data['parameters'];
//		self::create([
//			'type' => RequestType::_TYPE_PECAS_,
//			'status' => StatusRequest::_STATUS_AGUARDANDO_,
//			'reason' => $data['reason'],
//			'parameters' => json_encode($parameters),
//			'idrequester' => $idrequester,
//		]);
//		return "Requisição de " . $parameters['opcao'] . " aberta com sucesso!";
//	}
//
//	static public function sendPartsRequest($data)
//	{
//		$Request = self::accept($data);
//		$data['owner_id'] = $Request->requester->tecnico->idcolaborador;
//		$data['id'] = $Request->getParametersUncoded()->id;
//		PartStock::assign($data);
//		return "Requisição aceita com sucesso!";
//	}
//
//	/*
//	 * ========================================================
//	 * TOOLS ==================================================
//	 * ========================================================
//	 */
//	static public function openToolsRequest($data)
//	{
//		$idrequester = $data['idrequester'];
//		$parameters = $data['parameters'];
//		self::create([
//			'type' => RequestType::_TYPE_FERRAMENTAS_,
//			'status' => StatusRequest::_STATUS_AGUARDANDO_,
//			'reason' => $data['reason'],
//			'parameters' => json_encode($parameters),
//			'idrequester' => $idrequester,
//		]);
//		return "Requisição de " . $parameters['opcao'] . " aberta com sucesso!";
//	}
//
//	static public function sendToolsRequest($data)
//	{
//		dd('sendToolsRequest');
//		$Request = self::accept($data);
//		$data['idtecnico'] = $Request->requester->tecnico->idtecnico;
//		if ($Request->type == RequestType::_TYPE_SELOS_) {
//			Selo::assign($data);
//		} elseif ($Request->type == RequestType::_TYPE_LACRES_) {
//			Lacre::assign($data);
//		}
//		return "Requisição aceita com sucesso!";
//	}
//
//	/*
//	 * ========================================================
//	 * PATTERNS ==================================================
//	 * ========================================================
//	 */
//	static public function openPatternsRequest($data)
//	{
//		$idrequester = $data['idrequester'];
//		$parameters = $data['parameters'];
//		self::create([
//			'type' => RequestType::_TYPE_PADROES_,
//			'status' => StatusRequest::_STATUS_AGUARDANDO_,
//			'reason' => $data['reason'],
//			'parameters' => json_encode($parameters),
//			'idrequester' => $idrequester,
//		]);
//		return "Requisição de " . $parameters['opcao'] . " aberta com sucesso!";
//	}
//
//	static public function sendPatternsRequest($data)
//	{
//		dd('sendPatternsRequest');
//		$Request = self::accept($data);
//		$data['idtecnico'] = $Request->requester->tecnico->idtecnico;
//		if ($Request->type == RequestType::_TYPE_SELOS_) {
//			Selo::assign($data);
//		} elseif ($Request->type == RequestType::_TYPE_LACRES_) {
//			Lacre::assign($data);
//		}
//		return "Requisição aceita com sucesso!";
//	}



}