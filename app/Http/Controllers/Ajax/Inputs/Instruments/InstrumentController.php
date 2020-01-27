<?php

namespace App\Http\Controllers\Ajax\Inputs\Instruments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inputs\Instruments\InstrumentRequest;
use App\Models\Inputs\Instruments\Instrument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class InstrumentController extends Controller {

	public $entity = "instruments";
	public $sex = "M";
	public $name = "Instrumento";
	public $names = "Instrumentos";
	public $main_folder = 'pages.settings.instruments';
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
     *
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request ) {
        $data = Instrument::findOrFail( $request->get('id') );
        return $this->returning( ['instrument'=>$data ] );
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Inputs\Instruments\Instrument $instrument
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Instrument $instrument ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $instrument->getShortName() );
		return new JsonResponse( [
			'status'  => $instrument->delete(),
			'message' => $message,
		], 200 );
	}
}
