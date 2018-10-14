<?php

namespace App\Contracts\Repositories;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MessagesRepositoryInterface
{
    public function getAllChatMessages(Chat $chat, int $limit, string $lastMessageDate = null) : LengthAwarePaginator;

    public function store(array $data) : Message;
}