<?php

namespace App\Providers;

use App\Contracts\Services\RedisStorageServiceInterface;
use App\Observers\UserObserver;
use App\Services\RedisStorageService;
use App\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RedisStorageServiceInterface::class, function() {
            return new RedisStorageService(app(Redis::class));
        });
    }
}
