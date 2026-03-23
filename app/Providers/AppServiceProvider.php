<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $appUrl = config('app.url');
        if (!empty($appUrl) && strpos(strtolower($appUrl), 'https://') === 0) {
            URL::forceScheme('https');
            URL::forceRootUrl($appUrl);
        }
    }
}
