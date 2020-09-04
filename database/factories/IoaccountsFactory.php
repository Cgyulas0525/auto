<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ioaccounts;
use Faker\Generator as Faker;

$factory->define(Ioaccounts::class, function (Faker $faker) {

    return [
        'partner' => $faker->randomDigitNotNull,
        'tipus' => $faker->randomDigitNotNull,
        'datum' => $faker->word,
        'osszeg' => $faker->word,
        'leiras' => $faker->text,
        'io' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
