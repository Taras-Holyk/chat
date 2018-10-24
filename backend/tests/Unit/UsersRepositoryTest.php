<?php

namespace Tests\Unit;

use App\Contracts\Repositories\UsersRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersRepositoryTest extends TestCase
{
    public function testPaginate()
    {
        $usersRepository = app(UsersRepositoryInterface::class);

        $this->assertInstanceOf(LengthAwarePaginator::class, $usersRepository->paginate(rand(1, 10)));
    }
}
