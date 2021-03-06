<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\MessagesRepositoryInterface;
use App\Contracts\Services\RedisStorageServiceInterface;
use App\Events\ChatUpdated;
use App\Events\MessageCreated;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\StoreTemporaryMessageRequest;
use App\Http\Resources\Message;
use App\Http\Resources\Messages;
use App\Models\Chat;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * @param Chat $chat
     * @param CreateMessageRequest $request
     * @param MessagesRepositoryInterface $messagesRepository
     * @param RedisStorageServiceInterface $storage
     * @return Message
     */
    public function store(
        Chat $chat,
        CreateMessageRequest $request,
        MessagesRepositoryInterface $messagesRepository,
        RedisStorageServiceInterface $storage
    ) {
        $message = $messagesRepository->store([
            'chat_id' => $chat->id,
            'user_id' => auth()->id(),
            'text' => $request->input('text')
        ]);

        if ($message) {
            broadcast(new MessageCreated($message))->toOthers();
            event(new ChatUpdated($message->chat));

            $storage->delete("chat.{$chat->id}:tmp-msg:user." . auth()->id());
        }

        return new Message($message ?? []);
    }

    /**
     * @param Chat $chat
     * @param Request $request
     * @param MessagesRepositoryInterface $messagesRepository
     * @return Messages
     */
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

    /**
     * @param Chat $chat
     * @param StoreTemporaryMessageRequest $request
     * @param RedisStorageServiceInterface $storage
     * @return \Illuminate\Http\JsonResponse
     */
    public function temporaryStore(
        Chat $chat,
        StoreTemporaryMessageRequest $request,
        RedisStorageServiceInterface $storage
    ) {
        $storage->set("chat.{$chat->id}:tmp-msg:user." . auth()->id(), $request->input('text'));

        return response()->json([
            'text' => $request->input('text')
        ], 201);
    }

    /**
     * @param Chat $chat
     * @param RedisStorageServiceInterface $storage
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTemporary(
        Chat $chat,
        RedisStorageServiceInterface $storage
    ) {
        return response()->json([
            'text' => $storage->get("chat.{$chat->id}:tmp-msg:user." . auth()->id())
        ]);
    }
}
