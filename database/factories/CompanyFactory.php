<?php

use Faker\Generator as Faker;

$factory->define(\App\Companies\Company::class, function (Faker $faker) {
	//$company_id = ($faker->boolean) ? \App\Companies\Company::all()->random(1)->first()->id : NULL;
    return [
	    'franchise' => false
    ];
});
