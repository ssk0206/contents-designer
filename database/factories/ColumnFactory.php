<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Column;
use Faker\Generator as Faker;

$factory->define(Column::class, function (Faker $faker) {
    static $number = 1;

    return [
        'content' => 'コンテンツが入りますコンテンツが入りますコンテンツが入ります',
        'order' => $number++,
    ];
});
