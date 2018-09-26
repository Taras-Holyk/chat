<?php

namespace App\Repositories;

use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Contracts\Repositories\ViewableInterface;
use App\User;
use Elasticquent\ElasticquentCollection;
use Elasticquent\ElasticquentResultCollection;

class UsersRepository implements UsersRepositoryInterface, ViewableInterface
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getById(string $id) : User
    {
        return $this->model->where('id', $id)->first();
    }

    public function all() : ElasticquentCollection
    {
        return $this->model->get();
    }

    public function search(string $keyword) : ElasticquentResultCollection
    {
        return $this->model->search($keyword);
    }
}