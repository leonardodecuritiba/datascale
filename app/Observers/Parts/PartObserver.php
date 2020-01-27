<?php

namespace App\Observers\Parts\Settings;

use App\Models\Commons\Picture;
use App\Models\Commons\Security;
use App\Models\Parts\Part;
use Illuminate\Http\Request;

class PartObserver {
    protected $request;
    protected $table = 'parts';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the Provider created event.
     *
     * @param  \App\Models\Parts\Part $part
     *
     * @return void
     */
    public function created( Part $part ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $part->id,
	    ]);
	    //
//	    return $request->file('picture');
    }
	/**
	 * Listen to the Part updating event.
	 *
	 * @param  \App\Models\Parts\Part $part
	 *
	 * @return void
	 */
	public function saving( Part $part ) {
		// //testar
		if($this->request->has('picture')){
			$part->attachPicture([
				'src'       => $this->request->file('picture'),
				'title'     => NULL
			]);
		}
	}
	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Parts\Part $part
	 *
	 * @return void
	 */
	public function deleting( Part $part ) {
//        $part->servico_prestados()->delete();
		if($part->picture_id != NULL) $part->dettachPicture();
		$part->prices->each(function ($p){
			$p->delete();
		});

		$part->apparatu_parts->each(function ($p){
			$p->delete();
		});
	}
}