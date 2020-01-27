<?php

namespace App\Observers\Ipem;

use App\Models\Commons\Security;
use App\Models\Ipem\Pam;
use Illuminate\Http\Request;

class PamObserver {
    protected $request;
    protected $table = 'pams';

    public function __construct( Request $request ) {
        $this->request = $request;
    }

	/**
     * Listen to the InstrumentBase created event.
     *
     * @param  \App\Models\Ipem\Pam $pam
     *
     * @return void
     */
    public function created( Pam $pam ) {
	    //CRIAR UMA SEGURANÇA
	    Security::onCreate([
		    'table' => $this->table,
		    'pk'    => $pam->id,
	    ]);
    }
	/**
	 * Listen to the Part InstrumentBase event.
	 *
	 * @param  \App\Models\Ipem\Pam $pam
	 *
	 * @return void
	 */
	public function saving( Pam $pam ) {
		// //testar
		if($this->request->has('picture')){
			$pam->attachPicture([
				'src'       => $this->request->file('picture'),
				'title'     => NULL
			]);
		}
	}
	/**
	 * Listen to the InstrumentBase deleting event.
	 *
	 * @param  \App\Models\Ipem\Pam $pam
	 *
	 * @return void
	 */
	public function deleting( Pam $pam ) {
		if($pam->picture_id != NULL) $pam->dettachPicture();
		$pam->instruments->each(function ($p){
			$p->delete();
		});
	}
}