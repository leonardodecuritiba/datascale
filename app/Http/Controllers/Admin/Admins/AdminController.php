<?php

namespace App\Http\Controllers\Admin\Admins;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\Admins\AdminRequest;
use App\Models\Admins\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

	public $entity = "admins";
	public $sex = "M";
	public $name = "Administrador";
	public $names = "Administradores";
	public $main_folder = 'admin.admins';
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
			'page_title'  => '',
			'main_title'  => '',
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
		$this->page->response = Admin::get()->map( function ( $s ) {
			return [
				'id'              => $s->id,
				'user_id'         => $s->user_id,
				'name'            => $s->getShortName(),
				'email'           => $s->getShortEmail(),
				'created_at'      => $s->getCreatedAtFormatted(),
				'created_at_time' => $s->getCreatedAtTime(),
				'active'          => $s->getActiveFullResponse()
			];
		} );

		return view( $this->main_folder . '.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function profile() {
		$admin = Auth::user()->admin;

		return view( $this->main_folder . '.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $admin );
	}
	/**
	 * Display the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( $this->main_folder . '.master' )
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
		$admin = Admin::with( 'user' )->findOrFail( $id );
		return view( $this->main_folder . '.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $admin );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Admin\Admins\AdminRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( AdminRequest $request, $id )
	{
		$data = Admin::findOrFail( $id );
		$data->update( $request->all() );
		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Admin\Admins\AdminRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( AdminRequest $request )
	{
		$data = Admin::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Admins\Admin $admin
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Admin $admin ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $admin->getShortName() );
		$admin->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $message,
		], 200 );
	}
}
