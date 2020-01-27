<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class NotificationController extends Controller {

	public $entity = "notifications";
	public $sex = "F";
	public $name = "Notificação";
	public $names = "Notificações";
	public $main_folder = 'pages.human_resources.notifications';
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
			'page_title'  => '',
			'title'       => 'Notificação',
			'subtitle'    => 'Notificações',
			'noresults'   => '',
			'tab'         => 'data',
			'breadcrumb'  => array(),
			'notifications'  => array(),
		];
		$this->breadcrumb( $route );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index()
    {
        $this->page->response = $this->user->notifications;
        $this->page->create_option = 0;
		return view( 'pages.human_resources.notifications.index' )
			->with( 'Page', $this->page );
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id ) {
        $this->user->deleteNotification($id);
        $message = $this->getMessageFront( 'DELETE', 'Notificação' );
        return new JsonResponse( [
            'status'  => 1,
            'message' => $message,
        ], 200 );
    }

}
