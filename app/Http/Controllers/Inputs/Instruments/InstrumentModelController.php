<?php

namespace App\Http\Controllers\Inputs\Instruments;

use App\Http\Controllers\Controller;
use App\Models\Inputs\Instruments\InstrumentBrand;
use App\Models\Inputs\Instruments\InstrumentModel;
use App\Http\Requests\Inputs\Instruments\InstrumentModelRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class InstrumentModelController extends Controller {

    public $entity = "instrument_models";
    public $sex = "F";
    public $name = "Modelo de Instrumento";
    public $names = "Modelos de Instrumento";
    public $main_folder = 'pages.settings.inputs.instrument_models';
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        $data = InstrumentModel::get()->map( function ( $s ) {
            return [
                'id'                => $s->id,
                'brand_name'        => $s->instrument_brand->getShortName(),
                'name'              => $s->getShortName(),
                'content'           => $s->getShortContent(),
                'created_at'        => $s->created_at_formatted,
                'created_at_time'   => $s->created_at_time,
                'active'            => $s->getActiveFullResponse()
            ];
        } );

        $this->page->response = $data;
        $this->page->create_option = 1;
        return view('pages.settings.instrument_models.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Create the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function create( ) {
        $this->page->auxiliar['instrument_brands'] = InstrumentBrand::getAlltoSelectList();
        return view('pages.settings.instrument_models.master' )
            ->with( 'Page', $this->page );
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data = InstrumentModel::findOrFail( $id );
        $this->page->auxiliar['instrument_brands'] = InstrumentBrand::getAlltoSelectList();
        $this->page->create_option = 1;
        return view('pages.settings.instrument_models.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }
    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inputs\Instruments\InstrumentModelRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( InstrumentModelRequest $request ) {
        $data = InstrumentModel::create( $request->all() );
        return $this->redirect( 'STORE', $data );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inputs\Instruments\InstrumentModelRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( InstrumentModelRequest $request, $id ) {
        $data = InstrumentModel::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inputs\Instruments\InstrumentModel $instrument_model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( InstrumentModel $instrument_model ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $instrument_model->getShortName() );
        return new JsonResponse( [
            'status'  => $instrument_model->delete(),
            'message' => $message,
        ], 200 );
    }
}
