<?php

namespace App\Http\Controllers\HumanResources;

use App\Filters\ClientFilter;
use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\ClientRequest;
use App\Models\Commons\CepCities;
use App\Models\Commons\CepStates;
use App\Models\HumanResources\Client;
use App\Models\HumanResources\Settings\LegalPerson;
use App\Models\HumanResources\Settings\Segment;
use App\Models\Ipem\Pam;
use App\Models\Inputs\Instruments\InstrumentSetor;
use App\Models\Parts\Settings\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public $entity = "clients";
    public $sex = "M";
    public $name = "Cliente";
    public $names = "Clientes";
    public $main_folder = 'pages.human_resources.clients';
    public $page = [];
    public $ClientFilter;

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
	    $this->ClientFilter = new ClientFilter();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {

	    $clients = $this->user->clients();
        $this->page->response = $this->ClientFilter->map($request, $clients);
        $this->page->create_option = 1;
        return view('pages.human_resources.clients.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->page->auxiliar = [
            'segments'          => Segment::getAlltoSelectList(),
            'states'            => CepStates::getAlltoSelectList(),
        ];
        return view('pages.human_resources.clients.master' )
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
        $data = Client::findOrFail( $id );

        $instruments = $data->instruments()->get()->map(function ( $s ) {
            return [
                'id'                => $s->id,
                'image'             => $s->thumb_image,
                'name'              => $s->getBaseDescription(),
                'serial_number'     => $s->serial_number,
                'inventory'         => $s->inventory,
                'label'             => $s->getNumberLabelSetted(),
                'seals'             => $s->getNumberSealsSetted(),
                'active'            => $s->getActiveFullResponse(),
//                'base'              => $s->pam->description,
//                'setor'             => $s->instrument_setor->description,
//                'address'           => $s->address,
//                'ip'                => $s->ip,
//                'year'              => $s->year,
//                'created_at_time'   => $s->created_at_time,
//                'created_at'        => $s->created_at_formatted,
            ];
        });

        $equipments = $data->equipments()->get()->map(function ( $s ) {
            return [
	            'id'                => $s->id,
	            'image'             => $s->thumb_image,
	            'name'              => $s->description,
	            'brand'             => $s->brand->description,
	            'model'             => $s->model,
	            'serial_number'     => $s->serial_number,
//	            'created_at'        => $s->created_at_formatted,
//	            'created_at_time'   => $s->created_at_time,
	            'active'            => $s->getActiveFullResponse(),
            ];
        });
        $this->page->create_option = 1;
        $this->page->auxiliar = [
            'segments'          => Segment::getAlltoSelectList(),
        	'states'            => CepStates::getAlltoSelectList(),
        	'brands'            => Brand::pluck('description','id'),
        	'instrument_setors' => InstrumentSetor::pluck('description','id'),
        	'pams'              => Pam::pluck('description','id'),
        ];
        return view('pages.human_resources.clients.master',[
            'Page'=>$this->page,
            'Data'=>$data,
            'instruments'=>$instruments,
            'equipments'=>$equipments
        ]);
    }

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HumanResources\ClientRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( ClientRequest $request ) {
		$data = Client::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HumanResources\ClientRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( ClientRequest $request, $id ) {
        $data = Client::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HumanResources\Client $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( Client $client ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $client->getShortName() );
        return new JsonResponse( [
            'status'  => $client->delete(),
            'message' => $message,
        ], 200 );
    }
}
