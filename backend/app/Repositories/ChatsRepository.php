<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatsRepositoryInterface;
use App\Contracts\Repositories\StorableInterface;
use App\Models\Chat;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ChatsRepository implements ChatsRepositoryInterface, StorableInterface
{
    private $model;

    public function __construct(Chat $model)
    {
        $this->model = $model;
    }

    public function getByUsersIds(array $usersIds)
    {
        return $this->model
            ->where('users', 'all', $usersIds)
            ->first();
    }

    public function store(array $data) : Chat
    {
        return $this->model->create($data);
    }

    public function getUserChats(User $user, int $limit) : LengthAwarePaginator
    {
        return $this->model
            ->where('users', 'all', [$user->id])
            ->whereHas('messages')
            ->paginate($limit);
    }
}