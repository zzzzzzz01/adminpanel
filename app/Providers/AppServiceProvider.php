<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\URL;

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
        // Faqat productionda ishlaydi
        if (app()->environment('production')) {

            // Agar reverse proxy bo‘lsa, foizlash
            URL::forceScheme('https');
        }

        // Sessiyadagi tilni o‘rnatish
        $locale = session('lang', 'uz');
        app()->setLocale($locale);
    }
}
