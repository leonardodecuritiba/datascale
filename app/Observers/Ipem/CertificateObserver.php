<?php

namespace App\Observers\Ipem;

use App\Models\Commons\Security;
use App\Models\Ipem\Certificate;
use Illuminate\Http\Request;

class CertificateObserver {
	protected $request;
	protected $table = 'certificates';

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	/**
	 * Listen to the InstrumentBase created event.
	 *
	 * @param  \App\Models\Ipem\Certificate $certificate
	 *
	 * @return void
	 */
	public function created( Certificate $certificate ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate( [
			'table' => $this->table,
			'pk'    => $certificate->id,
		] );
	}

	/**
	 * Listen to the Part InstrumentBase event.
	 *
	 * @param  \App\Models\Ipem\Certificate $certificate
	 *
	 * @return void
	 */
	public function saving( Certificate $certificate ) {
		// //testar
		if ( $this->request->has( 'file' ) ) {
			$certificate->attachFile( [
				'src'   => $this->request->file( 'file' ),
				'title' => null
			] );
		}
	}

	/**
	 * Listen to the InstrumentBase deleting event.
	 *
	 * @param  \App\Models\Ipem\Certificate $certificate
	 *
	 * @return void
	 */
	public function deleting( Certificate $certificate ) {
		if ( $certificate->file_id != null ) {
			$certificate->dettachFile();
		}
		$certificate->certificate_patterns->each( function ( $p ) {
			$p->delete();
		} );
	}
}