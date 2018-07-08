<?php

namespace App\Providers;

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Silber\Bouncer\BouncerFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        BouncerFacade::cache();
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
