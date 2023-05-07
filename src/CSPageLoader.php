<?php

namespace CreativeSyntax\PageLoader;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use CreativeSyntax\PageLoader\Http\Middleware\PageLoader;

class CSPageLoader extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     * Arindam Roy
     */
    public function boot(Kernel $kernel): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/page-loader.php', 'page-loader'
        );

        $this->publishes([
            __DIR__ . '/config/page-loader.php' => config_path('page-loader.php')
        ], 'page-loader:config');

        $kernel->appendMiddlewareToGroup('web', PageLoader::class);

        //php artisan vendor:publish --provider="CreativeSyntax\PageLoader\CSPageLoader" --force
        //php artisan vendor:publish --tag="page-loader:config"
    }
}