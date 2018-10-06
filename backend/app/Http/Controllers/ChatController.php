<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ChatsRepositoryInterface;
use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Http\Resources\Chat;
use App\Http\Resources\Chats;
use App\Models\Chat as ChatModel;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * @param ChatModel $chat
     * @return Chat
     */
    public function show(
        ChatModel $chat
    ) {
        return new Chat($chat ?? []);
    }
    /**
     * @param $chatUserId
     * @param UsersRepositoryInterface $usersRepository
     * @param ChatsRepositoryInterface $chatsRepository
     * @return Chat
     */
    public function store(
        $chatUserId,
        UsersRepositoryInterface $usersRepository,
        ChatsRepositoryInterface $chatsRepository
    ) {
        $user = $usersRepository->getById($chatUserId);
        if (auth()->user()->can('createChat', $user)) {
            $chat = $chatsRepository->getByUsersIds([auth()->id(), $user->id]);
            if (!$chat) {
                $chat = $chatsRepository->store(['users' => [auth()->id(), $user->id]]);
            }
        }

        return new Chat($chat ?? []);
    }

    /**
     * @param Request $request
     * @param ChatsRepositoryInterface $chatsRepository
     * @return Chats
     */
    public function index(
        Request $request,
        ChatsRepositoryInterface $chatsRepository
    ) {
        return new Chats($chatsRepository->getUserChats(
            auth()->user(),
            $request->input('limit', config('constants.pagination.default_elements_count'))
        ));
    }
}
