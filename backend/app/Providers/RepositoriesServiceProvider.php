<?php

namespace App\Providers;

use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Repositories\UsersRepository;
use App\User;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UsersRepositoryInterface::class, function() {
            return new UsersRepository(app(User::class));
        });
    }
}
