<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

$factory->define(App\Post::class, function (Faker\Generator $faker) {
	return [
        'name' => $faker->sentence(2, true),
        'author' => $faker->sentence(4, true),
		'description' => $faker->sentence(8, true),		
	];
});