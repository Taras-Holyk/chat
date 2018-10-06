<?php

namespace App\Providers;

use App\Contracts\Repositories\ChatsRepositoryInterface;
use App\Contracts\Repositories\MessagesRepositoryInterface;
use App\Contracts\Repositories\UsersRepositoryInterface;
use App\Models\Chat;
use App\Models\Message;
use App\Repositories\ChatsRepository;
use App\Repositories\MessagesRepository;
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
        $this->app->bind(MessagesRepositoryInterface::class, function() {
            return new MessagesRepository(app(Message::class));
        });
    }
}
