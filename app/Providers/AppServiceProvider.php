<?php


namespace App\Providers;

use App\Services\AbsensiService;
use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthService::class, function ($app) {
            return new AuthService();
        });

        $this->app->bind(AbsensiService::class, function ($app) {
            return new AbsensiService();
        });
    }
}