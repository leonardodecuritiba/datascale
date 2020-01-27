<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Users\Technician::class, function (Faker $faker) {
	$user = factory( App\Models\Users\User::class )->create();
	$user->attachRole( 1 );
	return [
		'user_id' => $user->id,
	    'desconto_max'  => $faker->randomFloat(1, 10),
	    'acrescimo_max' => $faker->randomFloat(1, 10),
    ];
});
