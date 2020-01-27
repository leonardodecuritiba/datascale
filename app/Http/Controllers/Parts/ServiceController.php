<?php

namespace App\Http\Controllers\Parts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parts\ServiceRequest;
use App\Models\Parts\Service;
use App\Models\Parts\Settings\Group;
use App\Models\Parts\Settings\Unity;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class ServiceController extends Controller
{
	public $entity = "services";
	public $sex = "M";
	public $name = "Serviço";
	public $names = "Serviços";
	public $main_folder = 'pages.parts.services';
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
		$data = Service::get()->map( function ( $s ) {
			return [
				'id'                => $s->id,
				'name'              => $s->getName(),
				'content'           => $s->getContent(),
				'group_id'          => $s->group_id,
				'group_name'        => $s->getGroupName(),
				'created_at'        => $s->created_at_formatted,
				'created_at_time'   => $s->created_at_time,
				'active'            => $s->getActiveFullResponse()
			];
		} );

		$this->page->response = $data;
		$this->page->create_option = 1;
		return view('pages.parts.services.index' )
			->with( 'Page', $this->page );
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->page->create_option = 1;
		$this->page->auxiliar['groups']             = Group::getAlltoSelectList();
		$this->page->auxiliar['unities']            = Unity::getAlltoSelectList();
		return view('pages.parts.services.master' )
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
		$data = Service::findOrFail( $id );
		$this->page->create_option = 1;
        $this->page->auxiliar['groups']             = Group::getAlltoSelectList();
        $this->page->auxiliar['unities']            = Unity::getAlltoSelectList();
		return view('pages.parts.services.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\ServiceRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( ServiceRequest $request ) {
		$data = Service::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}



	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Parts\ServiceRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( ServiceRequest $request, $id ) {
		$data = Service::findOrFail( $id );
		$data->update( $request->all() );
		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Parts\Service $service
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Service $service ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $service->getShortName() );
		return new JsonResponse( [
			'status'  => $service->delete(),
			'message' => $message,
		], 200 );
	}
}
