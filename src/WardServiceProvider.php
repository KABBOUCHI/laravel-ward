<?php

namespace KABBOUCHI\Ward;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerResources();
        $this->defineAssetPublishing();
    }

    /**
     * Register the LogViewer routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if (! config('ward.enable_routes')) {
            return;
        }

        Route::group([
            'prefix'     => config('ward.uri', 'ward'),
            'namespace'  => 'KABBOUCHI\Ward\Http\Controllers',
            'middleware' => config('ward.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Register the LogViewer resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ward');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            WARD_PATH.'/public' => public_path('vendor/ward'),
        ], 'ward-assets');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('WARD_PATH')) {
            define('WARD_PATH', realpath(__DIR__.'/../'));
        }

        $this->configure();
        $this->offerPublishing();
    }

    /**
     * Setup the configuration for LogViewer.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ward.php', 'ward'
        );
    }

    /**
     * Setup the resource publishing groups for LogViewer.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/ward.php' => config_path('ward.php'),
            ], 'ward-config');
        }
    }
}
