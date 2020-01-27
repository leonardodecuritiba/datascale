<?php

use Faker\Generator as Faker;

$factory->define( \App\Models\Requests\Settings\RequestPatternItem::class, function ( Faker $faker ) {
	return [
		'request_pattern_id' => \App\Models\Requests\RequestPattern::all()->random( 1 )->first()->id,
		'pattern_id'         => \App\Models\Ipem\Pattern::all()->random( 1 )->first()->id,
	];
} );
