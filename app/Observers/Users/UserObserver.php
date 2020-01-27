<?php

namespace App\Observers\Users;

use App\Models\Commons\Security;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\Users\User;
use Illuminate\Http\Request;

class UserObserver {

	protected $request;
	protected $table = 'users';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Users\User $user
	 *
	 * @return void
	 */
	public function created( User $user ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate([
			'table' => $this->table,
			'pk'    => $user->id,
		]);
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Users\User $user
	 *
	 * @return void
	 */
	public function creating( User $user ) {
		//CRIAR UM ADDRESS
		//CRIAR UM CONTACT
		//CRIAR UM PJURIDICA
		//CRIAR UM PFISICA
		$contact            = Contact::create( $this->request->all() );
		$address            = Address::create( $this->request->all() );
		$user->contact_id = $contact->id;
		$user->address_id = $address->id;
	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Users\User $user
	 *
	 * @return void
	 */
	public function saving( User $user ) {
		if ( $user->address != null ) {
			$user->address->update( $this->request->all() );
			$user->contact->update( $this->request->all() );
		}
	}
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Users\User $user
	 *
	 * @return void
	 */
	public function deleting( User $user ) {
		$user->address->delete();
		$user->contact->delete();
		//FALTA COMPLETAR AQUI
		/*
		$user->cost_center_for()->each(function ($c){
			$c->unsetCenterCost();
		});
		$user->equipments->each(function ($c){
			$c->delete();
		});
		$user->instruments->each(function ($c){
			$c->delete();
		});
		*/
		$user->labels->each( function ( $c ) {
			$c->delete();
		} );
		$user->seals->each( function ( $c ) {
			$c->delete();
		} );
		$user->patterns->each( function ( $c ) {
			$c->delete();
		} );
	}
}