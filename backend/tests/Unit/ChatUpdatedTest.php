<?php

namespace Tests\Unit;

use App\Events\ChatUpdated;
use App\Models\Chat;
use Illuminate\Broadcasting\PresenceChannel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatUpdatedTest extends TestCase
{
    private $event;

    public function __construct()
    {
        parent::__construct();
        parent::setUp();

        $this->event = new ChatUpdated(factory(Chat::class)->create());
    }
    public function testBroadcastOn()
    {
        $this->assertInstanceOf(PresenceChannel::class, $this->event->broadcastOn());
    }

    public function testBroadcastAs()
    {
        $this->assertEquals('chat.updated', $this->event->broadcastAs());
    }
}
