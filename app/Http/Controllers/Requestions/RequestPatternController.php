<?php

namespace App\Http\Controllers\Requestions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requestions\RequestPatternAttachPatternRequest;
use App\Http\Requests\Requestions\RequestPatternRequest;
use App\Models\Requests\RequestPattern;
use Faker\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class RequestPatternController extends Controller {
	public $entity = "patterns";
	public $sex = "M";
	public $name = "Padrão";
	public $names = "Padrões";
	public $main_folder = 'pages.requestions.patterns';
	public $page = [];

	public function __construct( Route $route ) {
		parent::__construct();
		$this->page = (object) [
			'entity'        => $this->entity,
			'main_folder'   => $this->main_folder,
			'name'          => $this->name,
			'names'         => $this->names,
			'sex'           => $this->sex,
			'auxiliar'      => array(),
			'response'      => array(),
			'title'         => '',
			'create_option' => 0,
			'subtitle'      => '',
			'noresults'     => '',
			'tab'           => 'data',
			'breadcrumb'    => array(),
		];
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$data = RequestPattern::get()->take( 20 )->map( function ( $s ) {
			return [
				'id'              => $s->id,
				'type_text'       => $s->type_text,
				'status_icon'     => $s->status_icon,
				'status_color'    => $s->status_color,
				'status_text'     => $s->status_text,
				'value_formatted' => $s->value_formatted,
				'total'           => $s->getTotal(),

				'name'            => $s->getShortName(),
				'reason'          => $s->reason,
				'response'        => $s->response,
				'created_at'      => $s->created_at_formatted,
				'created_at_time' => $s->created_at_time

			];
		} );

		$this->page->title    = 'Listagem de Requerimentos';
		$this->page->response = $data;

		return view( 'pages.requestions.patterns.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function createByDue() {

		$this->page->title                = 'Requerer ' . $this->names;
		$this->page->auxiliar = [
		    'type'              => 1,
		    'request_type'      => 'Requerimento por Validade',
		    'value'             => 200,
		    'request_value'     => 'R$200,00',
        ];
		return view( 'pages.requestions.patterns.master' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function createByBuy() {
		$this->page->title = 'Requerer ' . $this->names;

//		$this->page->auxiliar['users'] = User::getAlltoSelectList();
		return view( 'pages.requestions.patterns.buy' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function createByDegradation() {
		$s = Factory::create();

		for ( $i = 0; $i < 2; $i ++ ) {
			$data[] = [
				'id' => $s->randomNumber( 5 ),

				'model_text'   => "M",
				'brand_text'   => $s->randomElement( [ 'BR CAL', 'TOLEDO' ] ),
				'feature_text' => $s->randomElement( [ 'INOX', 'FERRO FUNDIDO' ] ),
				'mass_text'    => $s->randomNumber( 2 ) . "Kg",
				'void_text'    => $s->randomNumber( 2 ),

			];
		}

		$this->page->response             = $data;
		$this->page->title                = 'Requerer ' . $this->names;
		$this->page->auxiliar['patterns'] = array(
			'1KG - BR CAL - FERRO FUNDIDO - 2031',
			'2KG - BR CAL - INOX - 20311',
			'1KG - TOLEDO - INOX - 31',
			'3KG - BR CAL - FERRO FUNDIDO - 521',
			'5KG - BR CAL - FERRO FUNDIDO - 70',
			'10KG - TOLEDO - INOX - 88'
		);

		return view( 'pages.requestions.patterns.degradation' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function createByEntity() {
		$this->page->title = 'Requerer ' . $this->names;

//		$this->page->auxiliar['users'] = User::getAlltoSelectList();
		return view( 'pages.requestions.patterns.entity' )
			->with( 'Page', $this->page );
	}


    /**
     * Show the application dashboard.
     *
     * @param \App\Models\Requests\RequestPattern;
     *
     */
    public function store( RequestPatternRequest $request ) {
        $data = RequestPattern::create($request->all());
        $message = "Requisição de " . $this->names . " aberta com sucesso!";
        return response()->success( $message, $data, route( 'requestions.patterns.edit', $data->id ) );

    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data = RequestPattern::findOrFail($id);
        $this->page->auxiliar['patterns'] = Auth::user()->patterns_list();
        return view('pages.requestions.patterns.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }


    /**
     * Create the specified resource.
     *
     * @param  \App\Http\Requests\Requestions\RequestPatternAttachPatternRequest $request
     * @param  $request_pattern_id
     *
     * @return \Illuminate\Http\Response
     */
    public function attachPattern( RequestPatternAttachPatternRequest $request, $request_pattern_id ) {
        $data = RequestPattern::findOrFail( $request_pattern_id );
        $data->attachPattern( $request->all() );
        $message = $this->names . " atualizado com sucesso!";
        return response()->success( $message, $data, route( 'requestions.patterns.edit', $data->id ) );
    }

    /**
     * Create the specified resource.
     *
     * @param  $request_pattern_id
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function detachPattern( $request_pattern_id, $id ) {
        $data    = RequestPattern::findOrFail( $request_pattern_id );
        $result  = $data->detachPattern( $id );
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $result );

        return new JsonResponse( [
            'status'  => $id,
            'message' => $message,
        ], 200 );
    }
}
