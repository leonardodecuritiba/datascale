<?php

namespace App\Helpers;

use Carbon\Carbon as Date;
//use Jenssegers\Date\Date;

class DataHelper {
	// ******************** FUNCTIONS ******************************
	static public function getTimestamp( $value ) {
		return strtotime( $value );
	}
	static public function getPeriodText( $value ) {
		return Date::createFromTimestamp($value)->format('m/Y');
	}

	static public function now() {
		return Date::now()->format( 'H:i - d/m/Y' );
	}

	static public function getPercent2Float( $value ) {
		return floatval( str_replace( ',', '.', $value ) );
	}

	static public function getReal2Float( $value ) {
		return ( ( $value == '' ) || ( $value == null ) ) ? 0 : floatval( str_replace( ',', '.', str_replace( '.', '', $value ) ) );
	}

	static public function getFloat2Currency( $value ) {
		return 'R$ ' . self::getFloat2Real( $value );
	}

	static public function getFloat2Percent( $value ) {
		return self::getFloat2Real( $value ) . '%';
	}

	static public function getFloat2Real( $value ) {
		return number_format( $value, 2, ',', '.' );
	}

	static public function getFullPrettyDateTime( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'Y-m-d H:i:s', $value )->format( 'd/m/Y H:i:s' ) : $value;
	}

	static public function getPrettyDateTime( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'Y-m-d H:i:s', $value )->format( 'H:i - d/m/Y' ) : $value;
	}

	static public function getPrettyDateTimeToMonth( $value ) {
		Date::setLocale( 'pt_BR' );

		return ( $value != null ) ? Date::createFromFormat( 'Y-m-d H:i:s', $value )->format( 'F/Y' ) : $value;
	}

	static public function getPrettyDate( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'Y-m-d', $value )->format( 'd/m/Y' ) : $value;
	}

	static public function getPrettyToCorrectDate( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'd/m/Y', $value )->format( 'Y-m-d' ) : $value;
	}

	static public function getPrettyToCorrectDateTime( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'd/m/Y', $value )->format( 'Y-m-d H:i:s' ) : $value;
	}

	static public function setDate( $value ) {
		return ( ( $value != null ) && ( $value != '' ) ) ? Date::createFromFormat( 'dmY', self::getOnlyNumbers( $value ) )->format( 'Y-m-d' ) : null;
	}

	static public function getOnlyNumbers( $value ) {
		return ( $value != null ) ? preg_replace( "/[^0-9]/", "", $value ) : $value;
	}

	static public function getOnlyValues( $value ) {
		return ( $value != null ) ? preg_replace( "/[^0-9-.-,]/", "", $value ) : $value;
	}

	static public function getOnlyNumbersLetters( $value ) {
		return ( $value != null ) ? preg_replace( "/[^a-zA-Z0-9-]/", "", $value ) : $value;
	}

	static public function getShortName( $value ) {
		$value = explode( ' ', $value );

		return ( count( $value ) > 1 ) ? ( $value[0] . " " . end( $value ) ) : $value[0];
	}

	static public function mask( $val, $mask ) {
		if ( $val != null || $val != "" ) {
			$maskared = '';
			$k        = 0;
			for ( $i = 0; $i <= strlen( $mask ) - 1; $i ++ ) {
				if ( $mask[ $i ] == '#' ) {
					if ( isset( $val[ $k ] ) ) {
						$maskared .= $val[ $k ++ ];
					}
				} else {
					if ( isset( $mask[ $i ] ) ) {
						$maskared .= $mask[ $i ];
					}
				}
			}
		} else {
			$maskared = null;
		}

		return $maskared;
	}


		/**
		 * Friendly UTF-8 URL for all languages
		 *
		 * @param $string
		 * @param string $separator
		 * @return mixed|string
			 */
	static public function slugify($string, $separator = '-')
	{
	    // Remove accents
	    $string = remove_accents($string);

	    // Slug
	    $string = mb_strtolower($string);
	    $string = @trim($string);
	    $replace = "/(\\s|\\" . $separator . ")+/mu";
	    $subst = $separator;
	    $string = preg_replace($replace, $subst, $string);

	    // Remove unwanted punctuation, convert some to '-'
	    $punc_table = array(
	        // remove
	        "'" => '',
	        '"' => '',
	        '`' => '',
	        '=' => '',
	        '+' => '',
	        '*' => '',
	        '&' => '',
	        '^' => '',
	        '' => '',
	        '%' => '',
	        '$' => '',
	        '#' => '',
	        '@' => '',
	        '!' => '',
	        '<' => '',
	        '>' => '',
	        '?' => '',
	        // convert to minus
	        '[' => '-',
	        ']' => '-',
	        '{' => '-',
	        '}' => '-',
	        '(' => '-',
	        ')' => '-',
	        ' ' => '-',
	        ',' => '-',
	        ';' => '-',
	        ':' => '-',
	        '/' => '-',
	        '.' => '',
	        '|' => '-'
	    );
	    $string = str_replace(array_keys($punc_table), array_values($punc_table), $string);

	    // Clean up multiple '-' characters
	    $string = preg_replace('/-{2,}/', '-', $string);

	    // Remove trailing '-' character if string not just '-'
	    if ($string != '-') {
	        $string = rtrim($string, '-');
	    }

	//$string = rawurlencode($string);

		return $string;
	}

	static public function NewGuid($size = 5) {
		$s = strtoupper(md5(uniqid(rand(),true)));
		$guidText = substr($s,0,8);
		if($size > 1) $guidText .= '-' . substr($s,8,4) . '-';
		if($size > 2) $guidText .= substr($s,12,4). '-';
		if($size > 3) $guidText .= substr($s,16,4) . '-';
		if($size > 4) $guidText .= substr($s,20);

		return $guidText;
	}

	static public function calculateModulo11($value)
	{
		$dv = NULL;
		if ($value != NULL) {
			$sz = strlen($value);
			if ($sz > 0) {
				$sum = 0;
				foreach (range($sz + 1, 2) as $i => $number) {
					$calc = ($value[$i] * $number);
					$sum += $calc;
				}
				$dv = ($sum % 11); //dígito verificador
				if ($dv > 10) $dv = 0;
			}
		}
//        dd($dv);
		return ($dv >= 10) ? 0 : $dv;

	}

	static public function selectSealLabelReturn($id, $data) {
		$retorno = NULL;
		if (count($data) > 0) {
			foreach ($data as $i => $dt) {
				$retorno[] = array('id' => $dt->$id, 'text' => $dt->number_formatted, 'data' => $dt);
			}
		}
		echo json_encode($retorno);
	}

	static public function selectDefaultReturn( $id, $data ) {
		$retorno = null;
		if ( count( $data ) > 0 ) {
			foreach ( $data as $i => $dt ) {
				$retorno[] = array( 'id' => $dt->$id, 'text' => $dt->getContent(), 'data' => $dt );
			}
		}
		echo json_encode( $retorno );
	}

	static public function getVectorKeyFloat2Currency($values)
	{
		foreach ($values as $key => $value) {
			$values[$key . '_float'] = floatval($value);
			$values[$key] = self::getFloat2Currency($values[$key . '_float']);
		}
		return $values;
	}
}
