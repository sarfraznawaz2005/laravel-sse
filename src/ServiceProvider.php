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
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/Views', 'sse');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            // Publish the configuration file.
            $this->publishes([
                __DIR__ . '/Config/config.php' => config_path('sse.php'),
            ], 'sse.config');

            // Publish the views.
            $this->publishes([
                __DIR__ . '/Views' => base_path('resources/views/vendor/sse'),
            ], 'sse.views');

            // Publish the migrations.
            $this->publishes([
                __DIR__ . '/Migrations' => database_path('migrations')
            ]);
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
        $this->app->singleton('SSE', function () {
            return $this->app->make(SSE::class);
        });
    }
}
