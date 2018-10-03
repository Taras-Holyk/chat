<?php

namespace App\Contracts\Repositories;

interface StorableInterface
{
    public function store(array $data);
}