<?php

/**
 * Created by PhpStorm.
 * User: rle
 * Date: 27/04/18
 * Time: 07:20
 */
namespace App\Traits;


use App\Helpers\DataHelper;

trait UserCollaboratorTrait
{

    public function getNameDocument()
    {
        return $this->getName().' - ' .$this->getAttribute('cpf');
    }
    public function getDocumentos()
    {
        return json_encode([
            'CNH' => ($this->attributes['cnh'] != '') ? asset('uploads/' . $this->table . '/' . $this->attributes['cnh']) : asset('imgs/documents.png'),
            'Carteira de Trabalho' => ($this->attributes['carteira_trabalho'] != '') ? storage_path('/uploads/' . $this->table . '/' . $this->attributes['carteira_trabalho']) : asset('imgs/documents.png')
        ]);
    }

    /*
    public function has_equipamento()
    {
        return 0;
    }

    public function hasAvisosClientes($tipo)
    {
        return $this->user->hasRole($tipo);
    }

    public function isSelf()
    {
        return (Auth::user()->colaborador->idcolaborador == $this->attributes['idcolaborador']) ? 1 : 0;
    }
    // ******************** RELASHIONSHIP ******************************
    // ************************** HAS **********************************

    public function clientes_invalidos()
    {
        return Cliente::getInvalidos();
    }

    //************** BELONGS ********************************


    public function requisicoes()
    {
        return $this->hasMany('App\Models\Requests\Request', 'idrequester', 'idcolaborador');
    }

    public function requisicoes_waiting()
    {
        return $this->hasMany('App\Models\Requests\Request', 'idrequester', 'idcolaborador')->waiting();
    }


	public function patterns() {
		return $this->hasMany( PatternStock::class, 'owner_id',  'idcolaborador');
	}

	public function tools() {
		return $this->hasMany( ToolStock::class, 'owner_id',  'idcolaborador');
	}

	public function parts() {
		return $this->hasMany( PartStock::class, 'owner_id',  'idcolaborador');
	}
	// ************************** HAS **********************************


	public function vehicles() {
		return $this->belongsToMany( Vehicle::class, 'vechicle_stocks', 'idcolaborador', 'idvechicle' );
	}

	public function instruments() {
		return $this->belongsToMany( Instrument::class, 'instrument_stocks', 'idcolaborador', 'idinstrument' );
	}

	public function equipments() {
		return $this->belongsToMany( Equipment::class, 'equipment_stocks', 'idcolaborador', 'idequipment' );
	}

	public function voids() {
		return $this->hasMany( Voidx::class, 'creator_id', 'idcolaborador' );
	}

     */
}
