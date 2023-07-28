<?php


namespace App\Providers;

use App\Http\Controllers\api\KaryawanController;
use App\Services\AbsensiService;
use App\Services\KaryawanService;
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
        $this->app->bind(KaryawanService::class, function ($app) {
            return new KaryawanService();
        });
    }
}