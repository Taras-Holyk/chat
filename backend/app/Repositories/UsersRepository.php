<?php

namespace App\Repositories;

use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Contracts\Repositories\ViewableInterface;
use App\User;
use Elasticquent\ElasticquentResultCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UsersRepository implements UsersRepositoryInterface, ViewableInterface
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getById(string $id) : User
    {
        return $this->model->where('_id', $id)->first();
    }

    public function paginate(int $limit) : LengthAwarePaginator
    {
        return $this->model->paginate($limit);
    }

    public function search(string $keyword, int $offset, int $limit) : ElasticquentResultCollection
    {
        return $this->model->searchByQuery([
            'match' => [
                'name' => $keyword
            ]
        ], null, null, $limit, $offset);
    }
}