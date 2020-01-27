<?php

namespace App\Observers\HumanResources;

use App\Models\Commons\Security;
use App\Models\HumanResources\Provider;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\HumanResources\Settings\LegalPerson;
use Illuminate\Http\Request;

class ProviderObserver {

	protected $request;
	protected $table = 'providers';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\HumanResources\Provider $provider
	 *
	 * @return void
	 */
	public function created( Provider $provider ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate([
			'table' => $this->table,
			'pk'    => $provider->id,
		]);
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\HumanResources\Provider $provider
	 *
	 * @return void
	 */
	public function creating( Provider $provider ) {
		//CRIAR UM ADDRESS
		//CRIAR UM CONTACT
		//CRIAR UM PJURIDICA
		//CRIAR UM PFISICA
		$contact            = Contact::create( $this->request->all() );
		$address            = Address::create( $this->request->all() );
		$provider->contact_id = $contact->id;
		$provider->address_id = $address->id;

		if($this->request->get('type') == 1){
			$plegal = LegalPerson::create( $this->request->all() );
			$provider->legal_person_id = $plegal->id;
		}

	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\HumanResources\Provider $provider
	 *
	 * @return void
	 */
	public function saving( Provider $provider ) {
		if ( $provider->address != null ) {
			$provider->address->update( $this->request->all() );
			$provider->contact->update( $this->request->all() );
			$provider->legal_person->update( $this->request->all() );
		}
		if($this->request->has('picture')){
			$provider->attachPicture([
				'src'       => $this->request->file('picture'),
				'title'     => NULL
			]);
		}
	}
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\HumanResources\Provider $provider
	 *
	 * @return void
	 */
	public function deleting( Provider $provider ) {
		$provider->address->delete();
		$provider->contact->delete();
		$provider->legal_person->delete();
		$provider->parts->each(function ($p){
			$p->delete();
		});
		if($provider->picture_id != NULL) $provider->dettachPicture();
	}
}