<?php

namespace App\Http\Controllers\Ipem;

use App\Filters\LabelFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ipem\LabelRequest;
use App\Models\Inputs\Settings\Label;
use App\Models\Inputs\Settings\LabelSealStatus;
use App\Models\Requests\Request;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request as IlluminateRequest;
use Illuminate\Routing\Route;

class LabelController extends Controller {

	public $entity = "labels";
	public $sex = "F";
	public $name = "Marca de Reparo";
	public $names = "Marcas de Reparo";
	public $main_folder = 'pages.ipem.labels';
	public $page = [];
	public $LabelFilter;

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
		$this->breadcrumb( $route );
		$this->LabelFilter = new LabelFilter();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response as IlluminateRequest
	 */

	public function index(IlluminateRequest $request)	{
		$labels = Label::query(); //$this->user->labels();
		$this->page->response = $this->LabelFilter->map($request, $labels);

		$this->page->auxiliar = [
			'status'    => LabelSealStatus::getAlltoSelectList(),
			'users'     => User::getAlltoSelectList(),
		];

		$this->page->create_option = 0;
		return view('pages.ipem.labels.index' )
			->with( 'Page', $this->page );

	}

	/**
	 * Create the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( ) {
		$this->page->auxiliar = [
			'users'     => User::getAlltoSelectList(),
		];
		return view('pages.ipem.labels.create' )
			->with( 'Page', $this->page );
	}
	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Ipem\LabelRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( LabelRequest $request ) {

		$values = range($request->get('num_begin'),$request->get('num_end'),1);
		if (Label::whereIn('number', $values)->count() > 0) {
			return $this->error( ['Já existem Marcas de Reparo com essa numeração!'] );
		} else {
			$now = Carbon::now()->toDateTimeString();
			$user_id = $request->get('user_id');
			$data = array();
			foreach ($values as $value) {
				$data[] = [
					'created_at' => $now,
					'owner_id' => $user_id,
					'number' => $value
				];
			}
			Label::insert($data);
			$qtd = count($data);
			return response()->success( 'Foram adicionadas ' . $qtd . ' Marcas de Reparo: ' . implode('; ', $values), $data, route( 'labels.create' ) );
		}
	}


	/**
	 * Create the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function tracking( ) {

		$requests = Request::labels(); //$this->user->labels();
		$this->page->response = $requests->get()->map( function ( $s ) {
			return [
				'id'                => $s->id,
				'created_at'        => $s->created_at_formatted,
				'created_at_time'   => $s->created_at_time,

				'requester_text'    => $s->getRequesterName(),

				'details_text'      => $s->getParametersText(),
				'values'            => $s->getParametersValuesTextAttribute(),
				'reason'            => $s->reason,
				'response'          => $s->response,
				'parameters'        => $s->parameters,
				'quantity'          => $s->getParametersDecoded()->quantidade,

				'manager_text'      => $s->getNameManager(),

				'status_icon'       => $s->status_icon,
				'status_color'      => $s->status_color,
				'status_text'       => $s->status_text,

				'can_show_deny_btn'     => $s->canShowDenyBtn(),
				'can_show_acept_btn'    => $s->canShowAceptBtn(),
			];
		} );//$this->LabelFilter->map($request, $labels);

		$this->page->auxiliar = [
			'users'     => User::getAlltoSelectList(),
		];

		return view('pages.ipem.labels.requests' )
			->with( 'Page', $this->page );
	}


	/**
	 * Store the specified resource in storage.
	 *
	 * @return \Illuminate\Http\Request as IlluminateRequest
	 */

	public function deny(IlluminateRequest $request) {
		$data = $request->only('id','response');
		$data['manager_id'] = $this->user->id;
		$data = Request::deny($data);
		return response()->success( 'Requisição negada com sucesso!', $data, route( 'labels.tracking' ) );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @return \Illuminate\Http\Request as IlluminateRequest
	 */

	public function accept(IlluminateRequest $request) {
		$data = $request->only('id','values');
		$data['manager_id'] = $this->user->id;
		$data = Request::accept($data);
		return response()->success( 'Requisição aceita com sucesso!', $data, route( 'labels.tracking' ) );
	}
}
