<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
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

$factory->define(App\Models\User::class, function (Faker $faker) {
  $passwordHash = Hash::make('secret');
$rememberToken = str_random(10);  
    return [
        'name' => $faker->name,
        'role_id' => $faker->numberBetween(1,4),
        'email' => $faker->unique()->safeEmail,
        'password' =>   $passwordHash, // secret
        'role_id'=> rand(1,4),
        'remember_token' => $rememberToken,
    ];
});
