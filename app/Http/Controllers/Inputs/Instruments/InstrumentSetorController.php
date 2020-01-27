<?php

namespace App\Http\Controllers\Inputs\Instruments;

use App\Http\Controllers\Controller;
use App\Models\Inputs\Instruments\InstrumentSetor;
use App\Http\Requests\Inputs\Instruments\InstrumentSetorRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class InstrumentSetorController extends Controller {

    public $entity = "instrument_setors";
    public $sex = "F";
    public $name = "Setor de Instrumento";
    public $names = "Setores de Instrumento";
    public $main_folder = 'pages.settings.inputs.instrument_setors';
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
        $data = InstrumentSetor::get()->map( function ( $s ) {
            return [
                'id'                => $s->id,
                'name'              => $s->getShortName(),
                'content'           => $s->getShortContent(),
                'created_at'        => $s->created_at_formatted,
                'created_at_time'   => $s->created_at_time,
                'active'            => $s->getActiveFullResponse()
            ];
        } );

        $this->page->response = $data;
        $this->page->create_option = 1;
        return view('pages.settings.instrument_setors.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Create the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function create( ) {
        return view('pages.settings.instrument_setors.master' )
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
        $data = InstrumentSetor::findOrFail( $id );
        $this->page->create_option = 1;
        return view('pages.settings.instrument_setors.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }
    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inputs\Instruments\InstrumentSetorRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( InstrumentSetorRequest $request ) {
        $data = InstrumentSetor::create( $request->all() );
        return $this->redirect( 'STORE', $data );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inputs\Instruments\InstrumentSetorRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( InstrumentSetorRequest $request, $id ) {
        $data = InstrumentSetor::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inputs\Instruments\InstrumentSetor $instrument_setor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( InstrumentSetor $instrument_setor ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $instrument_setor->getShortName() );
        return new JsonResponse( [
            'status'  => $instrument_setor->delete(),
            'message' => $message,
        ], 200 );
    }
}
