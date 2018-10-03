<?php

namespace App\Providers;

use App\Contracts\Repositories\ChatsRepositoryInterface;
use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Models\Chat;
use App\Repositories\ChatsRepository;
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
        $this->app->bind(ChatsRepositoryInterface::class, function() {
            return new ChatsRepository(app(Chat::class));
        });
    }
}
