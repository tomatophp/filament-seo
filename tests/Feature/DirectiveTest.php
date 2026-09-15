<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

function setSeoSetting(string $name, mixed $value): void
{
    DB::table('settings')
        ->where('group', 'seo')
        ->where('name', $name)
        ->update(['payload' => json_encode($value)]);
}

it('compiles the @filamentSEO directive to php that renders at request time', function () {
    $compiled = Blade::compileString('@filamentSEO');

    expect($compiled)->toContain('<?php')
        ->toContain('filament-seo::directive');
});

it('renders the tracking tags from the current settings', function () {
    expect(Blade::render('@filamentSEO', deleteCachedView: true))->not->toContain('googletagmanager');

    setSeoSetting('seo_use_google_analytics', true);
    setSeoSetting('seo_google_analytics', 'G-TEST123');
    setSeoSetting('seo_use_google_search_console', true);
    setSeoSetting('seo_google_search_console_verification', 'verify-me');

    $html = Blade::render('@filamentSEO', deleteCachedView: true);

    expect($html)->toContain('G-TEST123')
        ->toContain('name="google-site-verification" content="verify-me"');
});
