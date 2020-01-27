<?php

namespace App\Http\Controllers\Requestions;

use App\Http\Controllers\Controller;
use App\Models\Requests\Request;
use App\Models\Users\User;
use Illuminate\Http\Request as IlluminateRequest;
use Illuminate\Routing\Route;

class SealController extends Controller
{
	public $entity = "seals";
	public $sex = "M";
	public $name = "Lacre";
	public $names = "Lacres";
	public $main_folder = 'pages.requestions.seals';
	public $page = [];

	public function __construct( Route $route ) {
		parent::__construct();
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
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$this->page->title             = 'Requerer ' . $this->names;
		$this->page->auxiliar['users'] = User::getAlltoSelectList();
		return view('pages.requestions.seals.master')
			->with('Page', $this->page);
	}

	/**
	 * Show the application dashboard.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 */
	public function store( IlluminateRequest $request ) {
		$data = Request::openLabelSealRequest( [
			'requester_id' => $this->user->id,
			'parameters'   => $request->get( 'quantity' ),
			'reason'       => $request->get( 'reason' ),
			'type'         => 'seals',
		] );

		$message = "Requisição de " . $this->names . " aberta com sucesso!";

		return response()->success( $message, $data, route( 'requestions.seals.create' ) );

	}

}
