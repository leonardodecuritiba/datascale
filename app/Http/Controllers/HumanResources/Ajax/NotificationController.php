<?php

namespace App\Http\Controllers\HumanResources\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
	 */

	public function read( $id )
    {
        return new JsonResponse( [
            'status'  => 1,
            'message' => Auth::user()->readNotification($id),
        ], 200 );
	}


}
