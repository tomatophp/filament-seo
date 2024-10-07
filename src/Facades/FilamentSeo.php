<?php

namespace TomatoPHP\FilamentSeo\Facades;

use Illuminate\Support\Facades\Facade;
use TomatoPHP\FilamentSeo\Services\SearchConsole;

/**
 * @method static SearchConsole google(string $client='service_account')
 */
class FilamentSeo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-seo';
    }
}
