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

        $twitter_keys = array(
            'oauth_access_token' => env('TWITTER_ACCESS_TOKEN',null),
            'oauth_access_token_secret' =>  env('TWITTER_ACCESS_TOKEN_SECRET',null),
            'consumer_key' =>  env('TWITTER_CONSUMER_KEY',null),
            'consumer_secret' =>  env('TWITTER_CONSUMER_KEY_SECRET',null)
        );
        $google = [
            'key'=>env('GOOGLE_CS_API_KEY',null),
            'cx'=>env('GOOGLE_CX',null)
        ];
        $this->app->make(SearchFactory::class)
            ->register(new SearchTwitter($twitter_keys))
            ->register(new SearchGoogle($google));
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
