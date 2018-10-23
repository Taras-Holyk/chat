<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Http\Resources\User;
use App\Http\Resources\Users;
use App\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @param UsersRepositoryInterface $usersRepository
     * @return Users
     */
    public function index(
        Request $request,
        UsersRepositoryInterface $usersRepository
    ) {
        $limit = $request->input('limit', 10);
        if ($request->input('search', '')) {
            $offset = ($request->input('page', 1) - 1) * $limit;
            $users = $usersRepository->search($request->input('search'), $offset, $limit);
            $users = new LengthAwarePaginator(
                $users,
                $users->totalHits(),
                $limit,
                $request->input('page', 1)
            );
        } else {
            $users = $usersRepository->paginate($limit);
        }

        return new Users($users);
    }

    /**
     * @param UserModel $user
     * @return User
     */
    public function show(UserModel $user)
    {
        return new User($user);
    }
}
