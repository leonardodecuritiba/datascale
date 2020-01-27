<?php

namespace App\Http\Controllers\Ajax\Inputs;

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
     * Show the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request ) {
        $data = Equipment::findOrFail( $request->get('id') );
        return $this->returning( ['equipment'=>$data ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inputs\Equipment $equipment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( Equipment $equipment ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $equipment->getShortName() );
        return new JsonResponse( [
            'status'  => $equipment->delete(),
            'message' => $message,
        ], 200 );
    }
}
