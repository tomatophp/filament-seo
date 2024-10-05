<?php

namespace TomatoPHP\FilamentSeo\Services;

/**
 *
 * @method static SearchConsole google()
 *
 */
class FilamentSeoServices
{
    public function google(): SearchConsole
    {
        $client = new SearchConsoleClient(new \Google_Client());
        return new SearchConsole($client);
    }
}
