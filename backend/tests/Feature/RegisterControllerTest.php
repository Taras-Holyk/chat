<?php

namespace Tests\Feature;

use App\User;
use Tests\ControllerTestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends ControllerTestCase
{
    public function testRegister()
    {
        $user = factory(User::class)->make();

        $response = $this->json('post', '/api/v1/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'name' => true,
                    'email' => true
                ]
            ]);
    }
}
