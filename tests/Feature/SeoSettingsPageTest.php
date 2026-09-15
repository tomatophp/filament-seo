<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Tests\Models\User;
use TomatoPHP\FilamentSeo\Filament\Pages\SeoSettings;
use TomatoPHP\FilamentSeo\Jobs\GoogleIndexURLJob;
use TomatoPHP\FilamentSeo\Settings\SeoAppSettings;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

// Issue #1: the seo settings migration needs the settings table. filament-settings-hub 5 creates it,
// so a fresh install migrates without publishing spatie/laravel-settings' migration first.
it('migrates the seo settings on a fresh database', function () {
    expect(DB::table('settings')->where('group', 'seo')->count())->toBe(9)
        ->and(app(SeoAppSettings::class)->seo_use_google_analytics)->toBeFalse();
});

it('renders the seo settings page', function () {
    get(SeoSettings::getUrl())->assertSuccessful();
});

it('saves the seo settings', function () {
    livewire(SeoSettings::class)
        ->fillForm([
            'seo_use_google_analytics' => true,
            'seo_google_analytics' => 'G-TEST123',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $settings = app(SeoAppSettings::class);
    $settings->refresh();

    expect($settings->seo_use_google_analytics)->toBeTrue()
        ->and($settings->seo_google_analytics)->toBe('G-TEST123');
});

it('requires the tracking id when google analytics is enabled', function () {
    livewire(SeoSettings::class)
        ->fillForm([
            'seo_use_google_analytics' => true,
            'seo_google_analytics' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['seo_google_analytics' => 'required']);
});

it('queues a google indexing request for a url', function () {
    Queue::fake();

    livewire(SeoSettings::class)
        ->callAction('googleIndex', data: ['url' => 'https://example.com/blog/hello'])
        ->assertHasNoActionErrors();

    Queue::assertPushed(GoogleIndexURLJob::class, fn (GoogleIndexURLJob $job): bool => $job->url === 'https://example.com/blog/hello');
});
