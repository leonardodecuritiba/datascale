<?php

namespace App\Observers\HumanResources\Settings;

use App\Models\Commons\Security;
use App\Models\HumanResources\Settings\Segment;
use Illuminate\Http\Request;

class SegmentObserver {
	protected $request;
	protected $table = 'segments';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\HumanResources\Settings\Segment $segment
	 *
	 * @return void
	 */
	public function created( Segment $segment ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate([
			'table' => $this->table,
			'pk'    => $segment->id,
		]);
	}
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\HumanResources\Settings\Segment $segment
	 *
	 * @return void
	 */
	public function deleting( Segment $segment ) {
        $segment->providers->each(function ($p){
            $p->delete();
        });
	}
}