<?php

namespace KABBOUCHI\LogViewer;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LogViewerServiceProvider extends ServiceProvider
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
        Route::group([
            'prefix'     => config('log-viewer.uri', 'logs'),
            'namespace'  => 'KABBOUCHI\LogViewer\Http\Controllers',
            'middleware' => config('log-viewer.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Register the LogViewer resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'log-viewer');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            LOG_VIEWER_PATH . '/public' => public_path('vendor/log-viewer'),
        ], 'log-viewer-assets');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!defined('LOG_VIEWER_PATH')) {
            define('LOG_VIEWER_PATH', realpath(__DIR__ . '/../'));
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
            __DIR__ . '/../config/log-viewer.php', 'log-viewer'
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
                __DIR__ . '/../config/log-viewer.php' => config_path('log-viewer.php'),
            ], 'log-viewer-config');
        }
    }
}