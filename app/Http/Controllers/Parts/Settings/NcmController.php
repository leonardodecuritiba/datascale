<?php

namespace App\Http\Controllers\Parts\Settings;

use App\Http\Controllers\Controller;
use App\Models\Parts\Settings\Ncm;
use App\Http\Requests\Parts\Settings\NcmRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class NcmController extends Controller {

    public $entity = "ncms";
    public $sex = "M";
    public $name = "NCM";
    public $names = "NCMs";
    public $main_folder = 'pages.settings.ncms';
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
        $data = Ncm::get()->map( function ( $s ) {
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
        return view('pages.settings.parts.ncms.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Create the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function create( ) {
        return view('pages.settings.parts.ncms.master' )
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
        $data = Ncm::findOrFail( $id );
        $this->page->create_option = 1;
        return view('pages.settings.parts.ncms.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }



	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\Settings\NcmRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( NcmRequest $request ) {
		$data = Ncm::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Parts\Settings\NcmRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( NcmRequest $request, $id ) {
        $data = Ncm::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parts\Settings\Ncm $ncm
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( Ncm $ncm ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $ncm->getShortName() );
        return new JsonResponse( [
            'status'  => $ncm->delete(),
            'message' => $message,
        ], 200 );
    }
}
