<?php

namespace App\Providers;

use App\Services\Sale\UserCoinService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Sale\CoinRepository;
use App\Repositories\Basic\UserRepository;
use App\Repositories\Sale\UserCoinRepository;
use App\Interfaces\Services\Sale\IUserCoinService;
use App\Interfaces\Repositories\Sale\ICoinRepository;
use App\Interfaces\Repositories\Basic\IUserRepository;
use App\Interfaces\Repositories\Sale\IUserCoinRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
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
