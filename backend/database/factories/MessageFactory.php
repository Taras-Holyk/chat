<?php

use Faker\Generator as Faker;
use App\Models\Message;
use App\Models\Chat;

$factory->define(Message::class, function (Faker $faker) {
    $chat = factory(Chat::class)->create();
    return [
        'chat_id' => $chat->_id,
        'user_id' => $chat->users[0],
        'text' => $faker->sentence
    ];
});
