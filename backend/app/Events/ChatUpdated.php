<?php

namespace App\Events;

use App\Http\Resources\Chat;
use App\Models\Chat as ChatModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $userId;
    public $chat;

    /**
     * ChatUpdated constructor.
     * @param ChatModel $chat
     */
    public function __construct(ChatModel $chat)
    {
        foreach ($chat->users as $item) {
            if ($item != auth()->id()) {
                $this->userId = $item;
                break;
            }
        }

        $this->chat = new Chat($chat);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel("chats.{$this->userId}");
    }

    public function broadcastAs()
    {
        return 'chat.updated';
    }
}
