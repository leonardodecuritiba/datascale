<?php

namespace App\Traits;

trait VariablesTrait {


    static public function getAlltoSelectList() {
        return self::all()->map( function ( $s ) {
            return [
                'id'          => $s['id'],
                'description' => isset($s['description']) ? $s['description'] : $s['code']
            ];
        } )->pluck( 'description', 'id' );
    }

	static public function all($columns = ['*'])
	{
	    return $collect = collect(config('variables.' . self::_NAME_));
	    if($columns != NULL){
            return $collect->get($columns);
        }
		return $collect;
	}

	static public function whereId($attribute)
	{
		return (object) self::all()->where('id', $attribute)->first();
	}

	static public function whereCode($attribute)
	{
		return (object) self::all()->where('code', $attribute)->first();
	}

	static public function whereDescription($attribute)
	{
		return (object) self::all()->where('description', $attribute)->first();
	}

}