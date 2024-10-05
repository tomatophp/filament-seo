<?php

namespace TomatoPHP\FilamentSeo\Facades;

use Illuminate\Support\Facades\Facade;
use TomatoPHP\FilamentSeo\Services\SearchConsole;

/**
 * @method SearchConsole google()
 */
class FilamentSeo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-seo';
    }
}
