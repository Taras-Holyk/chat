<?php

namespace App\Contracts\Repositories;

use App\Models\Chat;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ChatsRepositoryInterface
{
    public function getByUsersIds(array $usersIds) : ?Chat;

    public function getUserChats(User $user, int $limit) : LengthAwarePaginator;
}