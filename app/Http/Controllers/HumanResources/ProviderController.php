<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\ProviderRequest;
use App\Models\Commons\CepCities;
use App\Models\Commons\CepStates;
use App\Models\HumanResources\Provider;
use App\Models\HumanResources\Settings\Segment;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class ProviderController extends Controller
{
    public $entity = "providers";
    public $sex = "M";
    public $name = "Fornecedor";
    public $names = "Fornecedores";
    public $main_folder = 'pages.human_resources.providers';
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
        $data = Provider::with('picture')->get()->map( function ( $s ) {
            return [
                'id'                => $s->id,
                'image'             => $s->getThumbFileView(),
                'name'              => $s->responsible_name,
                'type'              => $s->type_name_text,
                'content'           => $s->short_description,
                'group'             => $s->group,
                'created_at'        => $s->created_at_formatted,
                'created_at_time'   => $s->created_at_time,
                'active'            => $s->getActiveFullResponse()
            ];
        } );

        $this->page->response = $data;
        $this->page->create_option = 1;
        return view('pages.human_resources.providers.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->page->auxiliar['segments'] = Segment::getAlltoSelectList();
	    $this->page->auxiliar['states'] = CepStates::getAlltoSelectList();
        return view('pages.human_resources.providers.master' )
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
        $data = Provider::findOrFail( $id );
        $this->page->create_option = 1;
        $this->page->auxiliar['segments'] = Segment::getAlltoSelectList();
        $this->page->auxiliar['states'] = CepStates::getAlltoSelectList();
        return view('pages.human_resources.providers.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HumanResources\ProviderRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( ProviderRequest $request ) {
		$data = Provider::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HumanResources\ProviderRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( ProviderRequest $request, $id ) {
        $data = Provider::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HumanResources\Provider $provider
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( Provider $provider ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $provider->getShortName() );
        return new JsonResponse( [
            'status'  => $provider->delete(),
            'message' => $message,
        ], 200 );
    }
}
