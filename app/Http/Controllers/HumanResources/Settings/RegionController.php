<?php

namespace App\Http\Controllers\HumanResources\Settings;

use App\Http\Controllers\Controller;
use App\Models\HumanResources\Settings\Region;
use App\Http\Requests\HumanResources\Settings\RegionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class RegionController extends Controller {

	public $entity = "regions";
	public $sex = "F";
	public $name = "Região";
	public $names = "Regiões";
	public $main_folder = 'pages.settings.human_resources.regions';
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
		$data = Region::get()->map( function ( $s ) {
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
		return view('pages.settings.human_resources.regions.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Create the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( ) {
		return view('pages.settings.human_resources.regions.master' )
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
		$data = Region::findOrFail( $id );
		$this->page->create_option = 1;
		return view('pages.settings.human_resources.regions.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}


	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HumanResources\Settings\RegionRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( RegionRequest $request ) {
		$data = Region::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HumanResources\Settings\RegionRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( RegionRequest $request, $id ) {
		$data = Region::findOrFail( $id );
		$data->update( $request->all() );

		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\HumanResources\Settings\Region $region
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Region $region ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $region->getShortName() );
		return new JsonResponse( [
			'status'  => $region->delete(),
			'message' => $message,
		], 200 );
	}
}
