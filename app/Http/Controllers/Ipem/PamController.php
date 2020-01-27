<?php

namespace App\Http\Controllers\Ipem;

use App\Http\Controllers\Controller;
use App\Models\Ipem\Pam;
use App\Http\Requests\Ipem\PamRequest;
use App\Models\Inputs\Instruments\InstrumentModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class PamController extends Controller {

    public $entity = "pams";
    public $sex = "F";
    public $name = "PAM";
    public $names = "PAMs";
    public $main_folder = 'pages.ipem.pams';
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
        $data = Pam::with('picture')->get()->map( function ( $s ) {
            return [
                'id'                => $s->id,
                'image'             => $s->getThumbFileView(),
                'name'              => $s->getShortName(),
                'content'           => $s->getShortContent(),
                'division'          => $s->division,
                'ordinance'         => $s->ordinance,
                'capacity'          => $s->capacity,
                'created_at'        => $s->created_at_formatted,
                'created_at_time'   => $s->created_at_time,
                'active'            => $s->getActiveFullResponse()
            ];
        } );

        $this->page->response = $data;
        $this->page->create_option = 1;
        return view('pages.ipem.pams.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Create the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function create( ) {
        $this->page->auxiliar['instrument_models'] = InstrumentModel::getAlltoSelectList();
        return view('pages.ipem.pams.master' )
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
        $data = Pam::findOrFail( $id );
        $this->page->auxiliar['instrument_models'] = InstrumentModel::getAlltoSelectList();
        $this->page->create_option = 1;
        return view('pages.ipem.pams.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }
    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ipem\PamRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( PamRequest $request ) {
        $data = Pam::create( $request->all() );
        return $this->redirect( 'STORE', $data );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ipem\PamRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( PamRequest $request, $id ) {
        $data = Pam::findOrFail( $id );
        $data->update( $request->all() );
        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ipem\Pam $pam
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( Pam $pam ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $pam->getShortName() );
        return new JsonResponse( [
            'status'  => $pam->delete(),
            'message' => $message,
        ], 200 );
    }
}
