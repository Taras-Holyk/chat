<?php

namespace App\Contracts\Services;

interface StorageServiceInterface
{
    public function set(string $key, string $value);

    public function get(string $key);

    public function delete(string $key);
}