<?php

namespace App\Services;

use App\Contracts\Services\RedisStorageServiceInterface;
use App\Contracts\Services\StorageServiceInterface;

class RedisStorageService implements StorageServiceInterface, RedisStorageServiceInterface
{
    private $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    public function set(string $key, string $value)
    {
        return $this->provider::set($key, $value);
    }

    public function get(string $key)
    {
        return $this->provider::get($key);
    }

    public function delete(string $key)
    {
        return $this->provider::del($key);
    }
}