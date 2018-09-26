<?php

namespace App\Contracts\Repositories;

interface ViewableInterface
{
    public function getById(string $id);
}