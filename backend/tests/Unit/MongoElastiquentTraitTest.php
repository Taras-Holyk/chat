<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MongoElastiquentTraitTest extends TestCase
{
    public function testAddAllToIndex()
    {
        $user = factory(User::class)->create();

        $this->assertNotEmpty($user::addAllToIndex());
    }

    public function testAddToIndex()
    {
        $user = factory(User::class)->create();
        $user->exists = null;

        $this->expectException(Exception::class);
        $user->addToIndex();
    }
}
