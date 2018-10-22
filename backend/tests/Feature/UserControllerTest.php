<?php

namespace Tests\Feature;

use Tests\ControllerTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends ControllerTestCase
{
    public function testIndex()
    {
        $response = $this->actingAs($this->user)
            ->json('get', '/api/v1/users', [
                'search' => $this->user->name
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
                        'id', 'name', 'email'
                    ]
                ]
            ]);;
    }

    public function testShow()
    {
        $response = $this->actingAs($this->user)
            ->json('get', "/api/v1/users/{$this->user->_id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'email' => true,
                    'name' => true
                ]
            ]);
    }
}
