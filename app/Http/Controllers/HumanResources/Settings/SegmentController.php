<?php

namespace App\Http\Controllers\HumanResources\Settings;

use App\Http\Controllers\Controller;
use App\Models\HumanResources\Settings\Segment;
use App\Http\Requests\HumanResources\Settings\SegmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class SegmentController extends Controller {

	public $entity = "segments";
	public $sex = "M";
	public $name = "Segmento";
	public $names = "Segmentos";
	public $main_folder = 'pages.settings.human_resources.segments';
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
		$data = Segment::get()->map( function ( $s ) {
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
		return view('pages.settings.human_resources.segments.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Create the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( ) {
		return view('pages.settings.human_resources.segments.master' )
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
		$data = Segment::findOrFail( $id );
		$this->page->create_option = 1;
		return view('pages.settings.human_resources.segments.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HumanResources\Settings\SegmentRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( SegmentRequest $request ) {
		$data = Segment::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HumanResources\Settings\SegmentRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( SegmentRequest $request, $id ) {
		$data = Segment::findOrFail( $id );
		$data->update( $request->all() );

		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\HumanResources\Settings\Segment $segment
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Segment $segment ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $segment->getShortName() );
		return new JsonResponse( [
			'status'  => $segment->delete(),
			'message' => $message,
		], 200 );
	}
}
