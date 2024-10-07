<?php

namespace TomatoPHP\FilamentSeo\Services;

/**
 *
 * @method static SearchConsole google(string $client='service_account')
 *
 */
class FilamentSeoServices
{
    public function google(string $client='service_account'): SearchConsole
    {
        $token = SearchConsoleClientFactory::createForConfig(config('filament-seo'));
        return (new SearchConsole($token));
    }
}
