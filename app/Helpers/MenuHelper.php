<?php

namespace App\Helpers;


class MenuHelper {

	static public function isRoute( $value )
    {
        $route = \Route::current()->getName();
        if(is_array($value)){
            return in_array($route, $value);
        }
        return ($route == $value);
	}

	static public function isMenu( $value ) {
		$uri = \Route::current()->uri;
		if ( is_array( $value ) ) {
			return in_array( $uri, $value );
		}

		return ! ( strpos( $uri, $value ) === false );
	}
}
