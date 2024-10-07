<?php

namespace TomatoPHP\FilamentSeo;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentSeo\Exceptions\InvalidConfiguration;
use TomatoPHP\FilamentSeo\Services\FilamentSeoServices;


class FilamentSeoServiceProvider extends ServiceProvider
{
    /**
     * @throws InvalidConfiguration
     */
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentSeo\Console\FilamentSeoInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-seo.php', 'filament-seo');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-seo.php' => config_path('filament-seo.php'),
        ], 'filament-seo-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-seo-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-seo');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-seo'),
        ], 'filament-seo-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-seo');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-seo'),
        ], 'filament-seo-lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        //Publish Routes
        $this->app->bind('filament-seo', function () {
            return new FilamentSeoServices();
        });

        $this->guardAgainstInvalidConfiguration(config('filament-seo'));


        Blade::directive('filamentSEO', function () {
            return   view('filament-seo::tags')->render() . "\n" .
                view('filament-seo::google-analytics')->render() . "\n" .
                view('filament-seo::axeptio')->render() . "\n" .
                view('filament-seo::google-tag')->render() . "\n" .
                view('filament-seo::google-search-console')->render();
        });
    }

    public function boot(): void
    {
        //you boot methods here
    }

    /**
     * @param  array|null  $searchConsoleConfig
     *
     * @throws InvalidConfiguration
     */
    protected function guardAgainstInvalidConfiguration(array $searchConsoleConfig = null): void
    {
        if ($searchConsoleConfig['auth_type'] == 'service_account' && ! file_exists($searchConsoleConfig['connections']['service_account']['application_credentials'])) {
            throw InvalidConfiguration::credentialsJsonDoesNotExist($searchConsoleConfig['connections']['service_account']['application_credentials']);
        }

        if ($searchConsoleConfig['auth_type'] == 'oauth_json' && ! file_exists($searchConsoleConfig['connections']['oauth_json']['auth_config'])) {
            throw InvalidConfiguration::credentialsJsonDoesNotExist($searchConsoleConfig['connections']['oauth_json']['auth_config']);
        }
    }
}
