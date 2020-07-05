<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'firstname' => $faker->name,
        'lastname' => $faker->lastName,
        'email' => $faker->email
    ];
});
