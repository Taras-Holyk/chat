<?php

namespace App\Contracts\Repositories;

use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ChatsRepositoryInterface
{
    public function getByUsersIds(array $usersIds);

    public function getUserChats(User $user, int $limit) : LengthAwarePaginator;
}