<?php

namespace Gregoriohc\Preview;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class PreviewServiceProvider extends LaravelServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleConfigs();

        if (! $this->app->routesAreCached() && $this->isEnabled()) {
            Route::get('_preview/{view}', '\Gregoriohc\Preview\Controller@show')->name('_preview.show');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function handleConfigs()
    {
        $configPath = __DIR__ . '/../config/preview.php';

        $this->publishes([$configPath => config_path('preview.php')]);

        $this->mergeConfigFrom($configPath, 'preview');
    }

    public static function isEnabled()
    {
        return ((config('app.debug') && 'local' === config('app.env')) || config('preview.force_enable'));
    }
}
