<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;
use App\Models\SocialLink;
use App\Models\Flag;

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
    public function boot()
{
    View::composer('front.layouts.*', function ($view) {
        $view->with([
            'menus' => Menu::all(),
            'socialLinks' => SocialLink::all(),
            'flags' => Flag::all(),
        ]);
    });
}
}
