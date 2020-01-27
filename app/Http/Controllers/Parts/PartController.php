<?php

namespace App\Http\Controllers\Parts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parts\PartRequest;
use App\Models\HumanResources\Provider;
use App\Models\Parts\Part;
use App\Models\Parts\Price;
use App\Models\Parts\Settings\Brand;
use App\Models\Parts\Settings\Cfop;
use App\Models\Parts\Settings\Cst;
use App\Models\Parts\Settings\Group;
use App\Models\Parts\Settings\NatureOperation;
use App\Models\Parts\Settings\Ncm;
use App\Models\Parts\Settings\Unity;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class PartController extends Controller
{
	public $entity = "parts";
	public $sex = "F";
	public $name = "Peça";
	public $names = "Peças";
    public $main_folder = 'pages.parts.parts';
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
		$data = Part::with('picture')->get()->map( function ( $s ) {
			return [
				'id'                => $s->id,
				'image'             => $s->getThumbFileView(),
				'name'              => $s->getName(),
				'type'              => $s->type_text,
				'content'           => $s->getContent(),
				'brand_id'          => $s->brand_id,
				'brand_name'        => $s->getBrandName(),
				'provider_id'       => $s->provider_id,
				'provider_name'     => $s->getProviderName(),
				'created_at'        => $s->created_at_formatted,
				'created_at_time'   => $s->created_at_time,
				'active'            => $s->getActiveFullResponse()
			];
		} );

		$this->page->response = $data;
		$this->page->create_option = 1;
		return view('pages.parts.parts.index' )
			->with( 'Page', $this->page );
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->page->create_option                 = 1;
		$this->page->auxiliar['types']             = ['part'=>'Peça', 'product'=>'Produto'];
		$this->page->auxiliar['providers']         = Provider::getAlltoSelectList();
		$this->page->auxiliar['groups']            = Group::getAlltoSelectList();
		$this->page->auxiliar['brands']            = Brand::getAlltoSelectList();
		$this->page->auxiliar['unities']           = Unity::getAlltoSelectList();
		$this->page->auxiliar['cfops']             = Cfop::getAlltoSelectList();
		$this->page->auxiliar['csts']              = Cst::getAlltoSelectList();
		$this->page->auxiliar['nature_operations'] = NatureOperation::getAlltoSelectList();
		$this->page->auxiliar['ncms']              = Ncm::getAlltoSelectList();
		$this->page->auxiliar['prices']            = Price::getAlltoSelectList();
		return view('pages.parts.parts.master' )
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
		$data                                      = Part::findOrFail( $id );
		$this->page->create_option                 = 1;
        $this->page->auxiliar['types']             = ['part'=>'Peça', 'product'=>'Produto'];
        $this->page->auxiliar['providers']         = Provider::getAlltoSelectList();
        $this->page->auxiliar['groups']            = Group::getAlltoSelectList();
        $this->page->auxiliar['brands']            = Brand::getAlltoSelectList();
        $this->page->auxiliar['unities']           = Unity::getAlltoSelectList();
        $this->page->auxiliar['cfops']             = Cfop::getAlltoSelectList();
		$this->page->auxiliar['csts']              = Cst::getAlltoSelectList();
        $this->page->auxiliar['nature_operations'] = NatureOperation::getAlltoSelectList();
        $this->page->auxiliar['ncms']              = Ncm::getAlltoSelectList();
		return view('pages.parts.parts.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\PartRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( PartRequest $request ) {
		$data = Part::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\PartRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( PartRequest $request, $id ) {
		$data = Part::findOrFail( $id );
		$data->update( $request->all() );
		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Parts\Part $part
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Part $part ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $part->getShortName() );
		return new JsonResponse( [
			'status'  => $part->delete(),
			'message' => $message,
		], 200 );
	}
}
