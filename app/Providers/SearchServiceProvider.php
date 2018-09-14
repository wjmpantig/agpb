<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\Search\SearchFactory;
use App\Factories\Search\SearchTwitter;
use App\Factories\Search\SearchGoogle;
class SearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make(SearchFactory::class)
            ->register(new SearchTwitter(config('services.twitter')))
            ->register(new SearchGoogle(config('services.google')));
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SearchFactory::class);

    }
}
