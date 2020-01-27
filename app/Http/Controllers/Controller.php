<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $user;

    public function __construct(  ) {
        $this->middleware( 'auth' );
        $this->middleware( function ( $request, $next ) {
            $this->user = Auth::user();
            return $next( $request );
        } );
    }
	/**
	 * Define error messages.
	 *
	 * @param $errors
	 *
	 * @return string
	 *
	 */
	public function error( $errors ) {
		return response()->error( $errors , $status = 200 );
	}
	//function ( $errors, $status = 400 )
	/**
	 * Define getMessageFront.
	 *
	 * @param $data
	 *
	 * @return string
	 *
	 */
	public function returning( $data ) {
		return response()->success( trans( 'messages.success' ), $data, [] );
	}

    /**
     * Define getMessageFront.
     *
     * @param $type
     * @param $data
     *
     * @return string
     *
     */
    public function redirect( $type, $data ) {
        return response()->success( $this->getMessageFront( $type ), $data, route( $this->entity . '.edit', $data->id ) );
    }

    /**
     * Define getMessageFront.
     *
     * @param $type
     *
     * @return string
     *
     */
    public function getMessageFront( $type, $name = null ) {
        if ( $type == 'DELETE' ) {
            return trans( 'messages.crud.' . $this->sex . '.' . strtoupper( $type ) . '.SUCCESS', [ 'name' => $name ] );
        }

        return trans( 'messages.crud.' . $this->sex . '.' . strtoupper( $type ) . '.SUCCESS', [ 'name' => $this->name ] );
    }

    /**
     * Define breadcrumb.
     *
     * @param  \Illuminate\Routing\Route $route
     *
     */
    public function breadcrumb( $route ) {
        $action                 = $route->getActionMethod();
        $this->page->title = trans( 'pages.view.' . strtoupper( $action ), [ 'name' => $this->names ] );
        $this->page->subtitle = trans( 'pages.view.' . strtoupper( $action ), [ 'name' => $this->names ] );
        $this->page->noresults  = trans( 'pages.view.NORESULTS.' . $this->sex, [ 'name' => $this->name ] );

        switch ( $action ) {
//			case 'index':
//				$this->PageResponse->breadcrumb = [
//					['route'=>route('index'),'text'=>'Home'],
//					['route'=>NULL,'text'=> $this->names]
//				];
//				break;
            case 'create':
                $this->page->breadcrumb = [
                    [ 'route' => route( 'index' ), 'text' => 'Home', 'icon' => 'home' ],
                    [ 'route' => route( $this->entity . '.index' ), 'text' => $this->names , 'icon' => 'book'],
                    [ 'route' => null, 'text' => trans( 'pages.view.CREATE', [ 'name' => $this->name ] ), 'icon' => 'plus-circle' ],
                ];
                break;
            case 'edit':
                $this->page->breadcrumb = [
                    [ 'route' => route( 'index' ), 'text' => 'Home', 'icon' => 'home' ],
                    [ 'route' => route( $this->entity . '.index' ), 'text' => $this->names, 'icon' => 'book' ],
                    [ 'route' => null, 'text' => trans( 'pages.view.EDIT', [ 'name' => $this->name ] ), 'icon' => 'pencil' ],
                ];
                break;
            default:
                $this->page->breadcrumb = [
                    [ 'route' => route( 'index' ), 'text' => 'Home', 'icon' => 'home' ],
                    [ 'route' => null, 'text' => $this->names, 'icon' => 'book' ]
                ];
                break;
        }
    }
}
