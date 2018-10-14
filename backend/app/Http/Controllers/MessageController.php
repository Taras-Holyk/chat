<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\MessagesRepositoryInterface;
use App\Events\MessageCreated;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Resources\Message;
use App\Http\Resources\Messages;
use App\Models\Chat;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(
        Chat $chat,
        CreateMessageRequest $request,
        MessagesRepositoryInterface $messagesRepository
    ) {
        $message = $messagesRepository->store([
            'chat_id' => $chat->id,
            'user_id' => auth()->id(),
            'text' => $request->input('text')
        ]);

        if ($message) {
            broadcast(new MessageCreated($message))->toOthers();
        }

        return new Message($message ?? []);
    }

    public function index(
        Chat $chat,
        Request $request,
        MessagesRepositoryInterface $messagesRepository
    ) {
        $messages = $messagesRepository->getAllChatMessages(
            $chat,
            $request->input('limit', 10),
            $request->input('last_message_date')
        );

        return new Messages($messages ?? []);
    }
}
