<?php

namespace App\Repositories;

use App\Contracts\Repositories\MessagesRepositoryInterface;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MessagesRepository implements MessagesRepositoryInterface
{
    private $model;

    public function __construct(Message $model)
    {
        $this->model = $model;
    }

    public function store(array $data) : Message
    {
        return $this->model->create($data);
    }

    public function getAllChatMessages(Chat $chat, int $limit) : LengthAwarePaginator
    {
        return $chat->messages()
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
    }
}