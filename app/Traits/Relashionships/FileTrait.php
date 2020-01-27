<?php

namespace App\Traits\Relashionships;

use App\Models\Commons\Filex;
use Illuminate\Support\Facades\File;


trait FileTrait {

	static public function getPath() {
		return 'uploads' . DIRECTORY_SEPARATOR . self::$file_path
		       . DIRECTORY_SEPARATOR;
	}

	public function getFileAttribute() {
		return $this->getFileView();
	}

	//============================================================
	//========================= FILE =============================
	//============================================================

	public function hasFile() {
		return ( $this->filex != null );
	}

	public function attachFile( array $attributes ) {
		try {
			$filename          = $attributes['src'];
			$attributes['src'] = md5( time() ) . '.' . $filename->getClientOriginalExtension();

			$path = self::getPath();

			if ( $this->file_id != null ) { //DELETAR
				$this->dettachFile();
			}

			$path = public_path( $path );
			File::makeDirectory( $path, $mode = 0777, true, true );
			$filename->move( $path, $attributes['src'] );

			$filex         = Filex::create( $attributes );
			$this->file_id = $filex->id;


		} catch ( \Exception $e ) {
			dd( $e->getMessage() );

			return false;
		}
	}

	public function dettachFile() {
		try {
			File::delete( self::getFullLinkPath() );
			$this->filex->delete();
		} catch ( \Exception $e ) {
			dd( $e->getMessage() );

			return false;
		}
	}

	public function getLinkFile() {
		return self::getPath() . $this->filex->src;
	}

	public function getLinkThumbFile() {
		return self::getPath() . 'thumb_' . $this->filex->src;
	}

	public function getThumbFileView() {
		return ( $this->file_id != null ) ? asset( $this->getLinkThumbFile() ) : asset( 'assets/images/temp.jpg' );
	}

	public function getFileView() {
		return ( $this->file_id != null ) ? asset( $this->getLinkFile() ) : asset( 'assets/images/temp.jpg' );
	}

	public function getFullLinkPath() {
		return public_path( $this->getLinkFile() );
	}

	public function getFullLinkThumbPath() {
		return public_path( $this->getLinkThumbFile() );
	}


	public function filex() {
		return $this->belongsTo( Filex::class, 'file_id' );
	}
}