<?php

namespace App\Http\Controllers\Inputs\Instruments;

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
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Inputs\Instruments\InstrumentRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( InstrumentRequest $request ) {
		$data = Instrument::create( $request->all() );
		$message = trans( 'messages.crud.' . $this->sex . '.UPDATE.SUCCESS', [ 'name' => $this->name ] );
		return response()->success( $message, $data, route( 'clients.edit', $data->client_id ) );

		return $this->redirect( 'STORE', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Inputs\Instruments\InstrumentRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( InstrumentRequest $request ) {
		$data = Instrument::findOrFail( $request->get('id') );
		$data->update( $request->all() );
		$message = trans( 'messages.crud.' . $this->sex . '.UPDATE.SUCCESS', [ 'name' => $this->name ] );
		return response()->success( $message, $data, route( 'clients.edit', $data->client_id ) );

		return $this->redirect( 'UPDATE', $data );
	}

}
