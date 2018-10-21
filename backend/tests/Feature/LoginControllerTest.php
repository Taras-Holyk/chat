<?php

namespace Tests\Feature;

use App\User;
use Tests\ControllerTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends ControllerTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $password = $this->faker->word;
        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);

        $response = $this->json('post', '/api/v1/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'name' => true,
                    'email' => true
                ],
                'meta' => [
                    'headers' => [],
                    'original' => [
                        'access_token' => true,
                        'token_type' => 'bearer',
                        'expires_in' => 0
                    ],
                    'exception' => null
                ]
            ]);
    }

    public function testLogout()
    {
        $response = $this->actingAs($this->user)
            ->json('post', '/api/v1/logout');

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }
}
