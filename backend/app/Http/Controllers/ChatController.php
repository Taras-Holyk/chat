<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ChatsRepositoryInterface;
use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Http\Resources\Chat;
use App\Http\Resources\Chats;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function show(
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
