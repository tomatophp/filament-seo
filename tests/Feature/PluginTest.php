<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentSeo\Filament\Pages\SeoSettings;
use TomatoPHP\FilamentSeo\FilamentSeoPlugin;

use function Pest\Laravel\artisan;

it('registers the plugin and its settings page on the panel', function () {
    $panel = Filament::getPanel('admin');

    expect($panel->getPlugin('filament-seo'))->toBeInstanceOf(FilamentSeoPlugin::class)
        ->and($panel->getPages())->toContain(SeoSettings::class);
});

it('skips the cms auto indexing hooks when filament-cms is not installed', function () {
    FilamentSeoPlugin::make()->allowAutoPostsIndexing()->boot(Filament::getPanel('admin'));

    expect(Event::hasListeners('TomatoPHP\FilamentCms\Events\PostCreated'))->toBeFalse();

    FilamentSeoPlugin::$allowAutoPostsIndexing = false;
});

it('runs the install command', function () {
    artisan('filament-seo:install')
        ->expectsOutputToContain('Filament SEO installed successfully.')
        ->assertSuccessful();
});
