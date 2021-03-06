<?php

namespace App\Http\Controllers\Ipem;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ipem\CertificateAttachPatternRequest;
use App\Models\Commons\Voidx;
use App\Models\Ipem\Certificate;
use App\Http\Requests\Ipem\CertificateRequest;
use App\Models\Ipem\Settings\PatternBrand;
use App\Models\Ipem\Settings\PatternFeature;
use App\Models\Ipem\Settings\PatternModel;
use App\Models\Users\User;
use Faker\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class CertificateController extends Controller {

	public $entity = "certificates";
	public $sex = "M";
	public $name = "Certificado";
	public $names = "Certificados";
	public $main_folder = 'pages.ipem.certificates';
	public $page = [];

	public function __construct( Route $route ) {
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
		$this->breadcrumb( $route );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index() {
		$data = Certificate::get()->map( function ( $s ) {
			return [
				'id'               => $s->id,
				'number'           => $s->number,
				'created_at'       => $s->created_at_formatted,
				'created_at_time'  => $s->created_at_time,
				'verified_at'      => $s->verified_at_formatted,
				'verified_at_time' => $s->verified_at_time,
				'due_at'           => $s->due_at_formatted,
				'due_at_time'      => $s->due_at_time
			];
		} );

		$this->page->response      = $data;
		$this->page->create_option = 1;

		return view( 'pages.ipem.certificates.index' )
			->with( 'Page', $this->page );
	}
	/**
	 * Create the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		$this->page->auxiliar = [
			'models'   => PatternModel::getAlltoSelectList(),
			'brands'   => PatternBrand::getAlltoSelectList(),
			'features' => PatternFeature::getAlltoSelectList(),
		];

		$this->page->title         = 'Certificado Padrão';
		$this->page->create_option = 1;

		return view( 'pages.ipem.certificates.master' )
			->with( 'Page', $this->page );
	}

	/**
	 * Create the specified resource.
	 *
	 * @param  \App\Http\Requests\Ipem\CertificateAttachPatternRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function attachPattern( CertificateAttachPatternRequest $request, $id ) {
		$data = Certificate::findOrFail( $id );
		$data->attachPattern( $request->all() );

		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Create the specified resource.
	 *
	 * @param  $certificate_id
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function detachPattern( $certificate_id, $id ) {
		$data    = Certificate::findOrFail( $certificate_id );
		$result  = $data->detachPattern( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $result );

		return new JsonResponse( [
			'status'  => $id,
			'message' => $message,
		], 200 );
	}

	/**
	 * Recreate the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function recreate() {
		$s = Factory::create();

		for ( $i = 0; $i < 5; $i ++ ) {
			$data[] = [
				'id' => $s->randomNumber( 5 ),

				'model_text'   => "M",
				'brand_text'   => $s->randomElement( [ 'BR CAL', 'TOLEDO' ] ),
				'feature_text' => $s->randomElement( [ 'INOX', 'FERRO FUNDIDO' ] ),
				'mass_text'    => $s->randomNumber( 2 ) . "Kg",
				'void_text'    => $s->randomNumber( 2 ),

			];
		}

		$this->page->auxiliar = [
			'models'   => [ 'M' ],
			'brands'   => [ 'BR CAL', 'TOLEDO' ],
			'masses'   => [ '1Kg', '2Kg', '3Kg', '4Kg', '5Kg', '10Kg' ],
			'features' => [ 'INOX', 'FERRO FUNDIDO' ],
			'voids'    => [ '1', '10', '23', '59', '53' ],
		];


		$this->page->title         = 'Recertificação';
		$this->page->response      = $data;
		$this->page->create_option = 1;

		return view( 'pages.ipem.certificates.recreate' )
			->with( 'Page', $this->page );
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function requests() {
//    	return 1;
		$s = Factory::create();

		for ( $i = 0; $i < 100; $i ++ ) {
			$data[] = [
				'id'              => $s->randomNumber( 5 ),
				'created_at'      => $s->date( 'd/m/Y H:m' ),
				'created_at_time' => $s->randomNumber( 5 ),

				'status_icon'  => 'time',
				'status_color' => 'warning',
				'status_text'  => 'Aguardando',

				'requester_text'  => $s->text( 20 ),
				'type_text'       => $s->randomElement( [
					'Requerimento Por Validade',
					'Requerimento Após Compra',
					'Requerimento Por Degradação',
					'Requerimento Téc. Matriz/Filial'
				] ),
				'value_formatted' => DataHelper::getFloat2Currency( $s->randomFloat( 3 ) ),
				'total'           => $s->randomNumber( 2 ) . 'Kg',

				'reason'   => $s->text( 20 ),
				'response' => ( $s->boolean ) ? $s->text( 20 ) : "",

				'can_show_deny_btn'  => $s->boolean,
				'can_show_acept_btn' => $s->boolean,

			];
		}

		$this->page->auxiliar = [
			'users' => User::getAlltoSelectList(),
			'voids' => Voidx::getAlltoSelectList(),
		];

		$this->page->response      = $data;
		$this->page->create_option = 1;

		return view( 'pages.ipem.certificates.requests' )
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
		$data                 = Certificate::findOrFail( $id );
		$this->page->auxiliar = [
			'models'   => PatternModel::getAlltoSelectList(),
			'brands'   => PatternBrand::getAlltoSelectList(),
			'features' => PatternFeature::getAlltoSelectList(),
			'voids'    => Voidx::getAlltoSelectList(),
		];

		return view( 'pages.ipem.certificates.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Ipem\CertificateRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( CertificateRequest $request ) {
		$data = Certificate::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Ipem\CertificateRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( CertificateRequest $request, $id ) {
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Ipem\Certificate $certificate
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( Certificate $certificate ) {
	}
}
