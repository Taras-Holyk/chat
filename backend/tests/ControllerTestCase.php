<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

abstract class ControllerTestCase extends TestCase
{
    use WithFaker;

    protected $user;
    protected $authToken;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->authToken = auth()->login($this->user);
    }
}
