<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Users\User::class, function (Faker $faker) {

	$company_id = ($faker->boolean) ? \App\Companies\Company::all()->random(1)->first()->id : NULL;
    return [
        'company_id'        => $company_id,
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'cpf'               => $faker->cpf( false ),
        'rg'                => $faker->rg( false ),
        'password'          => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token'    => str_random(10),
    ];
});