<?php

namespace App\Observers\Ipem\Settings;

use App\Models\Commons\Security;
use App\Models\Ipem\Settings\CertificatePattern;
use Illuminate\Http\Request;

class CertificatePatternObserver {
	protected $request;
	protected $table = 'certificate_patterns';

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	/**
	 * Listen to the InstrumentBase created event.
	 *
	 * @param  \App\Models\Ipem\Settings\CertificatePattern $certificate_pattern
	 *
	 * @return void
	 */
	public function created( CertificatePattern $certificate_pattern ) {
		//CRIAR UMA SEGURANÇA
		Security::onCreate( [
			'table' => $this->table,
			'pk'    => $certificate_pattern->id,
		] );
	}

	/**
	 * Listen to the InstrumentBase deleting event.
	 *
	 * @param  \App\Models\Ipem\Settings\CertificatePattern $certificate_pattern
	 *
	 * @return void
	 */
	public function deleting( CertificatePattern $certificate_pattern ) {
	}
}