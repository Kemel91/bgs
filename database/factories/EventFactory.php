<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use App\Event;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'date' => Carbon::now()->addDays(mt_rand(1, 10))->addHours(mt_rand(1, 24)),
        'city_id' => City::query()->pluck('id')->random()
    ];
});
