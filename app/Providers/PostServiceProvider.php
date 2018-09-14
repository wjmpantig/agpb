<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\Post\PostFactory;
use App\Factories\Post\PostTwitter;
use App\Factories\Post\PostFacebook;


class PostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make(PostFactory::class)
            ->register(new PostTwitter(config('services.twitter')))
            ->register(new PostFacebook());

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PostFactory::class);
    }
}
