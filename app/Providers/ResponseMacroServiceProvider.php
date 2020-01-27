<?php

namespace App\Providers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider {
	/**
	 * Register the application's response macros.
	 *
	 * @return void
	 */
	public function boot() {
		Response::macro( 'success', function ( $message, $data = null, $route = null, $status = 200 ) {
			if ( Request::is( 'api/*' ) || Request::is( 'ajax/*' )) {
				return new JsonResponse( [
					'message' => 'success',
					'status' => '1',
					'text'    => $message,
					'data'    => $data,
				], $status );
			} else {
				session()->forget( 'success' );
				session( [ 'success' => $message ] );

				return Redirect::to( $route );
			}
		} );

		Response::macro( 'error', function ( $errors, $status = 400 ) {
            if ( Request::is( 'api/*' ) || Request::is( 'ajax/*' )) {
				$content = [
					'message'   => 'error',
					'status'    => '0',
					'text'      => $errors,
				];
				throw new HttpResponseException( response()->json( $content, $status ) );
			} else {
//				dd(12232);
				return Redirect::back()->withErrors( $errors )->withInput();
			}
		} );
	}
}