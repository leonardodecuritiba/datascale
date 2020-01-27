<?php

namespace App\Http\Controllers\Parts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parts\PriceRequest;
use App\Models\Parts\Price;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class PriceController extends Controller
{
	public $entity = "prices";
	public $sex = "F";
	public $name = "Tabela Preço";
	public $names = "Tabelas Preço";
	public $main_folder = 'pages.parts.prices';
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
		$data = Price::get()->map( function ( $s ) {
			return [
				'id'                => $s->id,
				'name'              => $s->getName(),
				'content'           => $s->getContent(),
				'created_at'        => $s->created_at_formatted,
				'created_at_time'   => $s->created_at_time,
				'active'            => $s->getActiveFullResponse()
			];
		} );

		$this->page->response = $data;
		$this->page->create_option = 1;
		return view('pages.parts.prices.index' )
			->with( 'Page', $this->page );
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('pages.parts.prices.master' )
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
		$data = Price::findOrFail( $id );
		$this->page->create_option = 1;

		$breadcrumb = array(
			[ 'route' => route( 'prices.parts', $id), 'text' => 'Preços de Peças', 'icon' => 'barcode' ],
			[ 'route' => route( 'prices.services', $id), 'text' => 'Preços de Serviços', 'icon' => 'cogs' ],
		);
		$this->page->breadcrumb = array_merge($this->page->breadcrumb, $breadcrumb);

		return view('pages.parts.prices.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\PriceRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( PriceRequest $request ) {
		$data = Price::create($request->all());
		return $this->redirect( 'STORE', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\PriceRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( PriceRequest $request, $id ) {
		$data = Price::findOrFail( $id );
		$data->update( $request->all() );
		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Parts\Price $price
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Price $price ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $price->getShortName() );
		return new JsonResponse( [
			'status'  => $price->delete(),
			'message' => $message,
		], 200 );
	}



	/**
	 * Display the specified resource.
	 *
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function part_price( $id ) {
		$data = Price::findOrFail( $id );
		$this->page->create_option = 1;

		$this->page->title = trans( 'pages.view.EDIT', [ 'name' => 'Preços de Peças' ] );
		$this->page->subtitle = trans( 'pages.view.EDIT' , [ 'name' => 'Preços de Peças' ] );
		$this->page->noresults  = trans( 'pages.view.NORESULTS.M' , [ 'name' => 'Preços de Peças' ] );

		$this->page->breadcrumb = array(
			[ 'route' => route( 'index' ), 'text' => 'Home', 'icon' => 'home' ],
			[ 'route' => route( $this->entity . '.index' ), 'text' => $this->names, 'icon' => 'book' ],
			[ 'route' => route( 'prices.edit', $id), 'text' => trans( 'pages.view.EDIT', [ 'name' => $this->name ] ), 'icon' => 'pencil' ],
			[ 'route' => NULL, 'text' => 'Preços de Peças', 'icon' => 'barcode' ],
			[ 'route' => route( 'prices.services', $id ), 'text' => 'Preços de Serviços', 'icon' => 'cogs' ]
		);

		return view('pages.parts.prices.list.part_prices' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function service_price( $id ) {
		$data = Price::findOrFail( $id );
		$this->page->create_option = 1;

		$this->page->title = trans( 'pages.view.EDIT', [ 'name' => 'Preços de Serviços' ] );
		$this->page->subtitle = trans( 'pages.view.EDIT' , [ 'name' => 'Preços de Serviços' ] );
		$this->page->noresults  = trans( 'pages.view.NORESULTS.M' , [ 'name' => 'Preços de Serviços' ] );

		$this->page->breadcrumb = array(
			[ 'route' => route( 'index' ), 'text' => 'Home', 'icon' => 'home' ],
			[ 'route' => route( $this->entity . '.index' ), 'text' => $this->names, 'icon' => 'book' ],
			[ 'route' => route( 'prices.edit', $id), 'text' => trans( 'pages.view.EDIT', [ 'name' => $this->name ] ), 'icon' => 'pencil' ],
			[ 'route' => route( 'prices.parts', $id), 'text' => 'Preços de Peças', 'icon' => 'barcode' ],
			[ 'route' => NULL, 'text' => 'Preços de Serviços', 'icon' => 'cogs' ]
		);

		return view('pages.parts.prices.list.service_prices' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );

	}

}
