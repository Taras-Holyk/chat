<?php

namespace App\Events;

use App\Http\Resources\Message;
use App\Models\Message as MessageModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $message;
    private $chatId;

    /**
     * MessageCreated constructor.
     * @param MessageModel $message
     */
    public function __construct(MessageModel $message)
    {
        $this->chatId = $message->chat->id;
        $this->message = new Message($message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel("chat.{$this->chatId}");
    }

    public function broadcastAs()
    {
        return 'message.created';
    }
}
