<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Component;
use Faker\Generator as Faker;

$factory->define(Component::class, function (Faker $faker) {
    static $number = 1;

    return [
        'type' => 1,
        'order' => $number++,
    ];
});
