<?php

namespace App\Repositories;

use App\Contracts\Repositories\MessagesRepositoryInterface;
use App\Models\Chat;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use MongoDB\BSON\UTCDateTime;

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

    public function getAllChatMessages(Chat $chat, int $limit, string $lastMessageDate = null) : LengthAwarePaginator
    {
        $query = $chat->messages()
            ->orderBy('created_at', 'DESC');

        if ($lastMessageDate) {
            $query->where('created_at', '<', new UTCDateTime(
                Carbon::parse(str_replace(' ', '+', $lastMessageDate))->timestamp * 1000)
            );
        }

        return $query->paginate($limit);
    }
}