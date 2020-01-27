<?php

namespace App\Traits;

trait StringTrait {

    static public function getAlltoSelectList() {
        return self::active()->get()->map( function ( $s ) {
            return [
                'id'          => $s->id,
                'description' => $s->getName()
            ];
        } )->pluck( 'description', 'id' );
    }

    public function getShortName()
    {
        return str_limit($this->getName(), 20);
    }

    public function getShortContent()
    {
        return str_limit($this->getContent(), 50);
    }

}