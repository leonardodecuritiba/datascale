<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\User\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\Users\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class UserController extends FrontController {

	public $entity = "users";
	public $sex = "M";
	public $name = "Usuário";
	public $names = "Usuários";
	public $main_folder = 'admin.users';
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
			'title'       => 'Usuários',
			'subtitle'    => 'Usuários',
			'noresults'   => '',
			'tab'         => 'data',
			'breadcrumb'  => array(),
            'create_option' => 0,
		];
		$this->breadcrumb( $route );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index() {
//		$this->page->response = User::get()->map( function ( $s ) {
//			return [
//				'id'              => $s->id,
//				'user_id'         => $s->user_id,
//				'name'            => $s->getShortName(),
//				'email'           => $s->getShortEmail(),
//				'created_at'      => $s->getCreatedAtFormatted(),
//				'created_at_time' => $s->getCreatedAtTime(),
//				'active'          => $s->getActiveFullResponse()
//			];
//		} );

		$this->page->create_option = 1;
		return view( 'pages.human_resources.users.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function profile() {
		$user = Auth::user();

		return view(  'pages.human_resources.users.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $user );
	}
	/**
	 * Display the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view(  '.master' )
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
		$user = User::findOrFail( $id );
		return view( 'pages.human_resources.users.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $user );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\User\UserRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( UserRequest $request, $id )
	{
		$data = User::findOrFail( $id );
		$data->update( $request->all() );
		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\User\UserRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( UserRequest $request )
	{
		$data = User::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Users\User $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( User $user ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $user->getShortName() );
		$user->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $message,
		], 200 );
	}
}
