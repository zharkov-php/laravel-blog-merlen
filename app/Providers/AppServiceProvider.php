<?php

namespace App\Providers;

use App\Category;
use App\Post;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('pages.sidebar', function($view){

            $view->with('popularPosts', Post::getPopularPosts());
            $view->with('featuredPosts', Post::getFeaturedPosts());
            $view->with('recentPosts', Post::getRecentPosts());

        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
