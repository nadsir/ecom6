<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Admin;
use App\Section;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('nader1362'), // password
        'remember_token' => Str::random(10),
    ];
});
$factory->define(App\Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'type' => $faker->name,
        'mobile' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('nader1362'), // password
        'image' => $faker->name,
        'status' => 123456,
        'remember_token' => Str::random(10),
    ];
});
$factory->define(App\Section::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => $faker->numberBetween(1,3),

    ];
});



