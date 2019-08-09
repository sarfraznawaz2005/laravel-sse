<?php

namespace Sarfraznawaz2005\SSE;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'sse');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__ . '/Config/config.php' => config_path('sse.php'),
            ], 'sse.config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/Views' => base_path('resources/views/vendor/sse'),
            ], 'sse.views');
        }
    }

    /**
     * Register package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/config.php', 'sse');

        // Register the service the package provides.
        $this->app->singleton('sse', function () {
            return $this->app->make(Noty::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['SSE'];
    }
}
