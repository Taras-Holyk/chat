<?php

namespace Tests\Unit;

use App\Events\MessageCreated;
use App\Models\Message;
use Illuminate\Broadcasting\PresenceChannel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageCreatedTest extends TestCase
{
    private $event;

    public function __construct()
    {
        parent::__construct();
        parent::setUp();

        $this->event = new MessageCreated(factory(Message::class)->create());
    }

    public function testBroadcastOn()
    {
        $this->assertInstanceOf(PresenceChannel::class, $this->event->broadcastOn());
    }

    public function testBroadcastAs()
    {
        $this->assertEquals('message.created', $this->event->broadcastAs());
    }
}
