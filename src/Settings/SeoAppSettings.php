<?php

namespace TomatoPHP\FilamentSeo\Settings;

use Spatie\LaravelSettings\Settings;

class SeoAppSettings extends Settings
{
    public bool $seo_use_google_analytics = false;
    public ?string $seo_google_analytics = null;

    public bool $seo_use_google_tags_manager = false;
    public ?string $seo_google_tags_manager = null;

    public bool $seo_use_axeptio = false;
    public ?string $seo_axeptio_client_id = null;
    public ?string $seo_axeptio_cookies_version = null;

    public bool $seo_use_google_search_console = false;
    public ?string $seo_google_search_console_verification = null;

    public static function group(): string
    {
        return 'seo';
    }
}
