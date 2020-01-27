<?php

namespace App\Observers\HumanResources;

use App\Models\Commons\Security;
use App\Models\HumanResources\Client;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\HumanResources\Settings\LegalPerson;
use Illuminate\Http\Request;

class ClientObserver {

	protected $request;
	protected $table = 'clients';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\HumanResources\Client $client
	 *
	 * @return void
	 */
	public function created( Client $client ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate([
			'table' => $this->table,
			'pk'    => $client->id,
		]);
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\HumanResources\Client $client
	 *
	 * @return void
	 */
	public function creating( Client $client ) {
		//CRIAR UM ADDRESS
		//CRIAR UM CONTACT
		//CRIAR UM PJURIDICA
		//CRIAR UM PFISICA
		$contact            = Contact::create( $this->request->all() );
		$address            = Address::create( $this->request->all() );
		$client->contact_id = $contact->id;
		$client->address_id = $address->id;

		if($this->request->get('type') == 1){
			$plegal = LegalPerson::create( $this->request->all() );
			$client->legal_person_id = $plegal->id;
		}

	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\HumanResources\Client $client
	 *
	 * @return void
	 */
	public function saving( Client $client ) {
		if ( $client->address != null ) {
			$client->address->update( $this->request->all() );
			$client->contact->update( $this->request->all() );
			$client->legal_person->update( $this->request->all() );
		}
		if($this->request->has('picture')){
			$client->attachPicture([
				'src'       => $this->request->file('picture'),
				'title'     => NULL
			]);
		}
	}
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\HumanResources\Client $client
	 *
	 * @return void
	 */
	public function deleting( Client $client ) {
		if($client->picture_id != NULL) $client->dettachPicture();
		$client->address->delete();
		$client->contact->delete();
		$client->legal_person->delete();
		$client->cost_center_for()->each(function ($c){
			$c->unsetCenterCost();
		});
		$client->equipments->each(function ($c){
			$c->delete();
		});
		$client->instruments->each(function ($c){
			$c->delete();
		});
	}
}