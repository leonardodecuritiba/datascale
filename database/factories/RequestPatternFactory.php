<?php

use Faker\Generator as Faker;

$factory->define( \App\Models\Requests\RequestPattern::class, function ( Faker $faker ) {
	return [
		'status'       => 1,
		'requester_id' => 7,
		'type'         => $faker->numberBetween( 1, 3 ),
		'value'        => $faker->randomFloat( 3 ),
		'reason'       => $faker->text( 20 ),
		'response'     => ( $faker->boolean ) ? $faker->text( 20 ) : "",

	];
} );
