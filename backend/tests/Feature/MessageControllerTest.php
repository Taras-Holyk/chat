<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\Message;
use Tests\ControllerTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageControllerTest extends ControllerTestCase
{
    public function testStore()
    {
        $chat = factory(Chat::class)->create();
        $response = $this->actingAs($this->user)
            ->json('post', "/api/v1/chats/{$chat->_id}/relationships/messages", [
                'text' => $this->faker->sentence
            ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'text' => true,
                    'created_at' => true,
                    'user' => [
                        'id' => true,
                        'name' => true,
                        'email' => true
                    ]
                ]
            ]);
    }

    public function testIndex()
    {
        $chat = factory(Chat::class)->create();
        $messages = factory(Message::class, 5)->create([
            'chat_id' => $chat->_id
        ]);

        $response = $this->actingAs($this->user)
            ->json('get', "/api/v1/chats/{$chat->_id}/relationships/messages", [
                'last_message_date' => $messages->last()->created_at->addMinutes(5)->format(\DateTime::ISO8601)
            ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => true,
                'meta' => [
                    'current_page' => true,
                    'from' => true,
                    'last_page' => true,
                    'path' => true,
                    'per_page' => true,
                    'to' => true,
                    'total' => true
                ]
            ])->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'text', 'created_at', 'user' => [
                            'id', 'name', 'email'
                        ]
                    ]
                ]
            ]);
    }

    public function testTemporaryStore()
    {
        $chat = factory(Chat::class)->create();
        $messageText = $this->faker->sentence;
        $response = $this->actingAs($this->user)
            ->json('post', "/api/v1/chats/{$chat->_id}/relationships/messages/temporary", [
                'text' => $messageText
            ]);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'text' => $messageText
            ]);
    }

    public function testGetTemporary()
    {
        $chat = factory(Chat::class)->create();
        $response = $this->actingAs($this->user)
            ->json('get', "/api/v1/chats/{$chat->_id}/relationships/messages/temporary");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'text'
            ]);
    }
}
