<?php

namespace App\Http\Controllers\Parts\Settings;

use App\Http\Controllers\Controller;
use App\Models\Parts\Settings\Brand;
use App\Http\Requests\Parts\Settings\BrandRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class BrandController extends Controller {

	public $entity = "brands";
	public $sex = "F";
	public $name = "Marca";
	public $names = "Marcas";
	public $main_folder = 'pages.settings.parts.brands';
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
		$data = Brand::get()->map( function ( $s ) {
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
		return view('pages.settings.parts.brands.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Create the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( ) {
		return view('pages.settings.parts.brands.master' )
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
		$data = Brand::findOrFail( $id );
		$this->page->create_option = 1;
		return view('pages.settings.parts.brands.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}
	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\Settings\BrandRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( BrandRequest $request ) {
		$data = Brand::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\Settings\BrandRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( BrandRequest $request, $id ) {
		$data = Brand::findOrFail( $id );
		$data->update( $request->all() );

		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Parts\Settings\Brand $brand
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Brand $brand ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $brand->getShortName() );
		return new JsonResponse( [
			'status'  => $brand->delete(),
			'message' => $message,
		], 200 );
	}
}
