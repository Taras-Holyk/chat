<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Http\Resources\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(
        Request $request,
        UsersRepositoryInterface $usersRepository
    ) {
        if ($request->input('search', '')) {
            $users = $usersRepository->search($request->input('search'));
        } else {
            $users = $usersRepository->all();
        }

        return new Users($users);
    }
}
