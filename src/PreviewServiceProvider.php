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
        $this->publishes([
            __DIR__.'/../config/preview.php' => config_path('preview.php'),
        ]);

        if (!$this->app->routesAreCached()) {
            $middleware = [];
            if (request()->has('_middleware')) {
                $middleware = array_merge(config('preview.middleware'), explode(',', request('_middleware')));
            }

            Route::group(['middleware' => $middleware], function () {
                $route = trim(config('preview.route'), '\\');
                Route::get($route.'/{view}', '\Gregoriohc\Preview\Controller@show')->name('_preview.show');
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/preview.php', 'preview');
    }

    /**
     * Check if the package is enabled.
     *
     * @return bool
     */
    public static function isEnabled()
    {
        return (config('app.debug') && 'local' === config('app.env')) || config('preview.force_enable');
    }
}
