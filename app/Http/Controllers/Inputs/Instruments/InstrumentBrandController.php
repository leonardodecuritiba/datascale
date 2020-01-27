<?php

namespace App\Http\Controllers\Inputs\Instruments;

use App\Http\Controllers\Controller;
use App\Models\Inputs\Instruments\InstrumentBrand;
use App\Http\Requests\Inputs\Instruments\InstrumentBrandRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class InstrumentBrandController extends Controller {

    public $entity = "instrument_brands";
    public $sex = "F";
    public $name = "Marca de Instrumento";
    public $names = "Marcas de Instrumento";
    public $main_folder = 'pages.settings.instrument_brands';
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
        $data = InstrumentBrand::get()->map( function ( $s ) {
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
        return view('pages.settings.instrument_brands.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Create the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function create( ) {
        return view('pages.settings.instrument_brands.master' )
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
        $data = InstrumentBrand::findOrFail( $id );
        $this->page->create_option = 1;
        return view('pages.settings.instrument_brands.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }
    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inputs\Instruments\InstrumentBrandRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( InstrumentBrandRequest $request ) {
        $data = InstrumentBrand::create( $request->all() );
        return $this->redirect( 'STORE', $data );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inputs\Instruments\InstrumentBrandRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( InstrumentBrandRequest $request, $id ) {
        $data = InstrumentBrand::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inputs\Instruments\InstrumentBrand $instrument_brand
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( InstrumentBrand $instrument_brand ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $instrument_brand->getShortName() );
        return new JsonResponse( [
            'status'  => $instrument_brand->delete(),
            'message' => $message,
        ], 200 );
    }
}
