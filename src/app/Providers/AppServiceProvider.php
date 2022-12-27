<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Basic\UserRepository;
use App\Interfaces\Repositories\Basic\IUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerRepositories();
    }

    /**
     * @return void
     */
    public function registerRepositories(): void
    {
        $this->app->singleton(IUserRepository::class, UserRepository::class);
    }
}
