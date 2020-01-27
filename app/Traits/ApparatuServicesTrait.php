<?php

namespace App\Traits;

use App\Models\Inputs\Settings\LabelInstrument;
use App\Models\Inputs\Settings\SealInstrument;
use Carbon\Carbon;

trait ApparatuServicesTrait {

	public function updateLabelSealInstrument(array $data)
	{
//		dd($data);

		//UPDATE DOS LACRES E SELOS
		//caso não tenha lacre rompido, só atualizar defeito/manutenção

//	    dd(($request->has('selo_retirado_hidden') && $request->get('selo_retirado_hidden') != NULL));
		if (isset($data['broken_seal'])) {
			$now = Carbon::now()->toDateTimeString();
			//Na primeira vez que o técnico for dar manutenção no instrumento, deverá marcar SELO OUTRO e LACRE OUTRO

			/*** AFIXAÇAO DO SELO ***/
			//Afixar o Selo convencional na tabela SeloInstrumento
			LabelInstrument::set( $this, $data['label_setted'], $now );

			/*** RETIRADA DO SELO ***/
			//Nesse caso quer dizer que o selo está sendo editado pela segunda vez
			if (isset($data['label_unsetted_hidden']) && $data['label_unsetted_hidden'] != NULL)
			{
				LabelInstrument::unsetHidden($this, $data['label_unsetted_hidden'], $now);
			}

			//Nesse caso o selo é externo ou PRIMEIRA vez
			if (isset($data['other_label']))
			{
				//Nesse caso, criar um selo novo na tabela selos e atribuí-lo ao técnico em questão
//		        if (Selo::selo_exists($removed_label)) { // Testar para saber se já existe esse selo na base, por segurnaça
//			        dd('ERRO: SELO JÁ EXISTE');
//		        }
//				$selo = Selo::create([ // se não existir, inserir e retornar o novo id
//					'idtecnico'         => $this->tecnico->idtecnico,
//					'numeracao_externa' => $data['removed_label'],
//					'externo'           => 1,
//					'used'              => 1,
//				]);
				//Afixar/Retirar o selo na tabela SeloInstrumento
				if(isset($data['label_unsetted'])) LabelInstrument::unsetNew( $this, $data['label_unsetted'], $now );

			}

			//			dd($data);
			/*** AFIXAÇAO DOS LACRES ***/
			//Afixar os lacres na tabela LacreInstrumento
			SealInstrument::set( $this, $data['seals_setted'], $now );


			/*** RETIRADA DOS LACRES ***/
			//Nesse caso quer dizer que os lacres está sendo editado pela segunda vez
			if (isset($data['seals_unsetted_hidden']) && $data['seals_unsetted_hidden'] != NULL)
			{
				SealInstrument::unsetHidden($this, $data['seals_unsetted_hidden'], $now);
			}

			//Nesse caso os lacres são externos ou PRIMEIRA vez
			if (isset($data['other_seals'])) {
				$seals_unsetted_free =  trim($data['seals_unsetted_free']);
				if(($seals_unsetted_free != NULL) && ($seals_unsetted_free != '')){
					$seals_unsetted = explode(';',$seals_unsetted_free);

					//Nesse caso, criar um lacre novo na tabela lacress e atribuí-lo ao técnico em questão
					//Afixar/Retirar o lacre na tabela LacreInstrumento
					foreach ($seals_unsetted as $seal) {
						SealInstrument::unsetNew( $this, $seal, $now );
					}
				}
			}

		}
		return true;
	}


	static public function checkDoubleInstrument($order_id, $instrument_id)
	{
		return self::where('order_id', $order_id)
		           ->where('instrument_id', $instrument_id)->count();
	}

	static public function checkDoubleEquipment($order_id, $equipment_id)
	{
		return self::where('order_id', $order_id)
		           ->where('equipment_id', $equipment_id)->count();
	}

	// SERVICES

	public function checkServiceExists($service_id) //has_servico_prestados
	{
		return $this->apparatu_services->where('service_id',$service_id)->count();
	}

	public function apparatu_service($id)
	{
		return $this->apparatu_services->find($id);
	}

	// PARTS

	public function checkPartExists($part_id) //has_pecas_utilizadas
	{
		return $this->apparatu_parts->where('part_id',$part_id)->count();
	}

	public function apparatu_part($id)
	{
		return $this->apparatu_parts->find($id);
	}
}