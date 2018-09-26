<?php

namespace App\Contracts\Repositories;

use Elasticquent\ElasticquentCollection;
use Elasticquent\ElasticquentResultCollection;

interface UsersRepositoryInterface
{
    public function all() : ElasticquentCollection;

    public function search(string $keyword) : ElasticquentResultCollection;
}