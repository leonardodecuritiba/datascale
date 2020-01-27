<?php

namespace App\Http\Controllers\Parts;

use App\Http\Controllers\Controller;
use App\Models\Parts\ServicePrice;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class ServicePriceController extends Controller
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
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\PriceRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request ) {
		$data = ServicePrice::findOrFail( $request->get('id') );
		$data->update( $request->all() );
		return response()->success( $this->getMessageFront( 'UPDATE' ), $data, route( 'prices.services', $data->price_id ) );
	}

}
