<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Vanguard\Document;
use Vanguard\Role;
use Vanguard\Support\Enum\DocumentStatus;

$factory->define(Document::class, function (Faker $faker) {
    $clients = Role::where('name', 'User')
        ->first()
        ->users;

    $sum = $faker->randomFloat(2, 100, 10000);

    return [
        'user_id' => $faker->randomElement($clients->pluck('id')->toArray()),
        'status' => DocumentStatus::CONFIRMED,
        'document_number' => $faker->unique()->numberBetween(10000, 1000000),
        'document_type' => $faker->numberBetween(0, 1),
        'document_date' => $faker->dateTimeBetween('-1 month', 'now'),
        'currency_id' => $faker->numberBetween(1, 2),
        'sum' => $sum,
        'sum_without_vat' => $sum - $sum * 0.17,
        'vat' => $sum * 0.17
    ];
});
