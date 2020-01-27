<?php

namespace App\Observers\Parts\Settings;


use App\Models\Commons\Security;
use App\Models\Parts\Settings\Group;
use Illuminate\Http\Request;

class GroupObserver {
	protected $request;
	protected $table = 'groups';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Parts\Settings\Group $group
	 *
	 * @return void
	 */
	public function created( Group $group ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate([
			'table' => $this->table,
			'pk'    => $group->id,
		]);
	}

	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Parts\Settings\Group $group
	 *
	 * @return void
	 */
	public function deleting( Group $group ) {
        $group->parts->each(function ($p){
            $p->delete();
        });
        $group->services->each(function ($p){
            $p->delete();
        });
	}
}