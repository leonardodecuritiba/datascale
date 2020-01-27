<?php

namespace App\Http\Controllers\Ajax;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Models\Commons\CepCities;
use App\Models\Commons\SubGroup;
use App\Models\Users\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller {
	/**
	 * gET the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getStateCityToSelect() {
		$state_id = Input::get( 'id' );
		return ( $state_id == null ) ? $state_id : CepCities::where( 'state_id', $state_id )->get();
	}

	/**
	 * Active the specified resource from storage.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setActive() {

		$model  = Input::get( 'model' );
		$id     = Input::get( 'id' );
		$Entity = $model::findOrFail( $id );

		return new JsonResponse( [
			'status'  => 1,
			'message' => $Entity->updateActive()
		], 200 );
	}

	public function getAvailableLabels() {
		$value     = Input::has('value') ? Input::get('value') : '';
		$user_id = Input::has('user_id') ? Input::get('user_id') : NULL;
		$user   = ($user_id == NULL) ? Auth::user() : User::find($user_id);
		if($user!=NULL){
			$data = $user->available_labels();
			if($value != ""){
				$data->where('number', 'like', $value . "%");
			}
//			return $data->get();
			return DataHelper::selectSealLabelReturn('id', $data->get());
		}
		return $user;
	}

	public function getAvailableSeals() {

		$value     = Input::has('value') ? Input::get('value') : '';
		$user_id = Input::has('user_id') ? Input::get('user_id') : NULL;
		$user   = ($user_id == NULL) ? Auth::user() : User::find($user_id);

		if($user!=NULL){
			$data = $user->available_seals();
			if($value != ""){
				$data->where('number', 'like', $value . "%");
			}
//			return $data->get();
			return DataHelper::selectSealLabelReturn('id', $data->get());
		}
		return $user;
	}

	public function getAvailableVoids() {

		$value   = Input::has( 'value' ) ? Input::get( 'value' ) : '';
		$user_id = Input::has( 'user_id' ) ? Input::get( 'user_id' ) : null;
		$user    = ( $user_id == null ) ? Auth::user() : User::find( $user_id );

		if ( $user != null ) {
			$data = $user->available_voids();
			if ( $value != "" ) {
				$data->where( 'number', 'like', $value . "%" );
			}

//			return $data->get();
			return DataHelper::selectSealLabelReturn( 'id', $data->get() );
		}

		return $user;
	}

	public function getAvailablePatterns() {

		$value   = Input::has( 'value' ) ? Input::get( 'value' ) : '';
		$user_id = Input::has( 'user_id' ) ? Input::get( 'user_id' ) : null;
		$user    = ( $user_id == null ) ? Auth::user() : User::find( $user_id );

		if ( $user != null ) {
			$data = $user->patterns();
			if ( $value != "" ) {
				$data->where( 'mass', 'like', $value . "%" );
			}

//			return $data->get();
			return DataHelper::selectDefaultReturn( 'id', $data->get() );
		}

		return $user;
	}
}
