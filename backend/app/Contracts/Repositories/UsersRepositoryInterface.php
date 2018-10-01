<?php

namespace App\Contracts\Repositories;

use Elasticquent\ElasticquentResultCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UsersRepositoryInterface
{
    public function search(string $keyword, int $offset, int $limit) : ElasticquentResultCollection;

    public function paginate(int $limit) : LengthAwarePaginator;
}