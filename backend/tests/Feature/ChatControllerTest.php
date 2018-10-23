<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\Message;
use App\User;
use Tests\ControllerTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatControllerTest extends ControllerTestCase
{
    public function testShow()
    {
        $chat = factory(Chat::class)->create();
        factory(Message::class)->create([
            'chat_id' => $chat->_id
        ]);

        $response = $this->actingAs($this->user)
            ->json('get', "/api/v1/chats/{$chat->_id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'user' => [
                        'id' => true,
                        'name' => true,
                        'email' => true
                    ],
                    'last_message' => [
                        'id' => true,
                        'text' => true,
                        'created_at' => true,
                        'user' => [
                            'id' => true,
                            'name' => true,
                            'email' => true
                        ]
                    ]
                ]
            ]);
    }

    public function testStore()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->user)
            ->json('post', "/api/v1/chats/{$user->_id}");

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'user' => [
                        'id' => true,
                        'name' => true,
                        'email' => true
                    ],
                    'last_message' => null
                ]
            ]);
    }

    public function testIndex()
    {
        $chats = factory(Chat::class, 5)->create([
            'users' => [
                $this->user->_id,
                factory(User::class)->create()->_id
            ]
        ]);

        foreach ($chats as $chat) {
            factory(Message::class)->create([
                'chat_id' => $chat->_id,
                'user_id' => $this->user->_id
            ]);
        }
        $response = $this->actingAs($this->user)
            ->json('get', '/api/v1/chats');

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
                        'id',
                        'user' => [
                            'id', 'name', 'email'
                        ],
                        'last_message' => [
                            'id', 'text', 'created_at', 'user' => [
                                'id', 'name', 'email'
                            ]
                        ]
                    ]
                ]
            ]);;
    }
}
