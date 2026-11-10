<?php

namespace App\Providers;

use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Trust the reverse proxies / load balancers configured in the .env
        // (TRUSTED_PROXIES=* or a comma separated list of IP addresses).
        $trustedProxies = config('app.trusted_proxies');

        if (is_string($trustedProxies) && $trustedProxies !== '') {
            TrustProxies::at($trustedProxies);
        }

        // Force HTTPS URLs whenever the application is configured with an
        // https:// APP_URL (e.g. production behind a reverse proxy).
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
