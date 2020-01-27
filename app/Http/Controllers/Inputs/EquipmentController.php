<?php

namespace App\Http\Controllers\Inputs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inputs\EquipmentRequest;
use App\Models\Inputs\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class EquipmentController extends Controller {

    public $entity = "equipments";
    public $sex = "M";
    public $name = "Equipamento";
    public $names = "Equipamentos";
    public $main_folder = 'pages.settings.equipments';
    public $page = [];

    public function __construct( Route $route ) {
        $this->page = (object) [
            'entity'      => $this->entity,
            'main_folder' => $this->main_folder,
            'name'        => $this->name,
            'names'       => $this->names,
            'sex'         => $this->sex,
            'auxiliar'    => array(),
            'response'    => array(),
            'title'       => '',
            'create_option' => 0,
            'subtitle'    => '',
            'noresults'   => '',
            'tab'         => 'data',
            'breadcrumb'  => array(),
        ];
        $this->breadcrumb( $route );
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inputs\EquipmentRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( EquipmentRequest $request ) {
        $data = Equipment::create( $request->all() );
        return $this->redirect( 'STORE', $data );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inputs\EquipmentRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update( EquipmentRequest $request ) {
        $data = Equipment::findOrFail( $request->get('id') );
        $data->update( $request->all() );
        $message = trans( 'messages.crud.' . $this->sex . '.UPDATE.SUCCESS', [ 'name' => $this->name ] );
	    return response()->success( $message, $data, route( 'clients.edit', $data->client_id ) );

        return $this->returning('updated');
    }

}
