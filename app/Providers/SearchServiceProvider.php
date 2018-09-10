<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\Search\SearchFactory;
use App\Factories\Search\SearchTwitter;
class SearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $twitter_keys = array(
            'oauth_access_token' => env('TWITTER_ACCESS_TOKEN',null),
            'oauth_access_token_secret' =>  env('TWITTER_ACCESS_TOKEN_SECRET',null),
            'consumer_key' =>  env('TWITTER_CONSUMER_KEY',null),
            'consumer_secret' =>  env('TWITTER_CONSUMER_KEY_SECRET',null)
        );
        $this->app->make(SearchFactory::class)
            ->register(new SearchTwitter($twitter_keys));
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
