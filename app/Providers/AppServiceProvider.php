<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('categories', Category::all());
        View::share('tags', Tag::all());
        View::share('posts', Post::all());
        View::share('latestPosts', Post::latest()->take(5)->get());
        View::share('popularPosts', Post::orderBy('views', 'desc')->take(5)->get());
    }
}
