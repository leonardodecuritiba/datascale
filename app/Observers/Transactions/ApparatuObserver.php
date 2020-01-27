<?php

namespace App\Observers\Transactions;

use App\Models\Commons\Security;
use App\Models\Transactions\Apparatu;
use Illuminate\Http\Request;

class ApparatuObserver {
    protected $request;
    protected $table = 'apparatus';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Transactions\Apparatu $apparatu
     *
     * @return void
     */
    public function created( Apparatu $apparatu ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $apparatu->id,
	    ]);
    }
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Transactions\Apparatu $apparatu
	 *
	 * @return void
	 */
	public function deleting( Apparatu $apparatu )
	{
		//Remover o selo que foi afixado (nessa O.S.)
		foreach ( $apparatu->label_instrument_set as $li ) {
			$li->reverse();
		}

		//Remover os lacres que foram afixados (nessa O.S.)
		foreach ( $apparatu->seals_instrument_set as $si ) {
			$si->reverse();
		}

		//Reaver o selo antigo que foi desafixado ( nessa O.S.)
		foreach ( $apparatu->label_instrument_unset as $li ) {
			$li->reset();
		}

		//Reaver os lacres antigos que foram desafixados ( nessa O.S.)
		foreach ( $apparatu->seals_instrument_unset as $si ) {
			$si->reset();
		}

		//desfazer Apparatu.
		$apparatu->apparatu_parts->each(function ($p){
			$p->delete();
		});
		$apparatu->apparatu_services->each(function ($p){
			$p->delete();
		});
/*
			//Remover os lacres que foram afixados (nessa O.S.)
			foreach ( $this->lacres_instrumento_set as $lacres_instrumento ) {
				$lacres_instrumento->extorna();
			}

			//Reaver os lacres antigos que foram desafixados ( nessa O.S.)
			foreach ( $this->lacres_instrumento_unset as $lacres_instrumento ) {
				$lacres_instrumento->reafixa();
			}

			//Remover o selo que foi afixado (nessa O.S.)
			foreach ( $this->selo_instrumento_set as $selo_instrumento ) {
				$selo_instrumento->extorna();
			}

			//Reaver o selo antigo que foi desafixado ( nessa O.S.)
			foreach ( $this->selo_instrumento_unset as $selo_instrumento ) {
				$selo_instrumento->reafixa();
			}

			//remover serviços
			$this->remove_servico_prestados();
			//remover peças
			$this->remove_pecas_utilizadas();
			//remover kits

			//remover o aparelhoManutencao
			$this->forceDelete();
			return;
*/
	}
}