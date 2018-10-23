<?php

use Faker\Generator as Faker;
use App\Models\Chat;
use App\User;

$factory->define(Chat::class, function (Faker $faker) {
    return [
        'users' => [
            factory(User::class)->create()->_id,
            factory(User::class)->create()->_id
        ]
    ];
});
