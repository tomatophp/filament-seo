<?php

namespace TomatoPHP\FilamentSeo;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Event;
use TomatoPHP\FilamentSeo\Filament\Pages\SeoSettings;
use TomatoPHP\FilamentSeo\Jobs\GoogleIndexURLJob;
use TomatoPHP\FilamentSeo\Jobs\GoogleRemoveIndexURLJob;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

class FilamentSeoPlugin implements Plugin
{
    /**
     * Optional tomatophp/filament-cms integration: the post model and the post events that
     * (re)index or remove a post URL on Google. Resolved by name, so filament-cms stays optional.
     */
    protected const CMS_POST_MODEL = 'TomatoPHP\\FilamentCms\\Models\\Post';

    protected const CMS_POST_EVENTS = [
        'TomatoPHP\\FilamentCms\\Events\\PostCreated' => GoogleIndexURLJob::class,
        'TomatoPHP\\FilamentCms\\Events\\PostUpdated' => GoogleIndexURLJob::class,
        'TomatoPHP\\FilamentCms\\Events\\PostDeleted' => GoogleRemoveIndexURLJob::class,
    ];

    public static string $postURL = '/blog';

    public static string $postSlug = 'slug';

    public static bool $useGoogleIndexing = true;

    public static bool $allowAutoPostsIndexing = false;

    public static string $googleAuthType = 'service_account';

    public static bool $allowShield = false;

    public function getId(): string
    {
        return 'filament-seo';
    }

    public function allowAutoPostsIndexing(bool $allowAutoPostsIndexing = true): static
    {
        self::$allowAutoPostsIndexing = $allowAutoPostsIndexing;

        return $this;
    }

    public function allowShield(bool $allowShield = true): static
    {
        self::$allowShield = $allowShield;

        return $this;
    }

    public function isShieldAllowed(): bool
    {
        return self::$allowShield;
    }

    public function googleIndexing(bool $useGoogleIndexing): static
    {
        self::$useGoogleIndexing = $useGoogleIndexing;

        return $this;
    }

    public function googleAuthType(string $googleAuthType): static
    {
        self::$googleAuthType = $googleAuthType;

        return $this;
    }

    public function postUrl(string $postUrl): static
    {
        self::$postURL = $postUrl;

        return $this;
    }

    public function postSlug(string $postSlug): static
    {
        self::$postSlug = $postSlug;

        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            SeoSettings::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        if (self::$allowAutoPostsIndexing && class_exists(self::CMS_POST_MODEL)) {
            foreach (self::CMS_POST_EVENTS as $event => $job) {
                Event::listen($event, function ($event) use ($job): void {
                    $model = self::CMS_POST_MODEL;
                    $post = $model::query()->find($event->data['id'] ?? null);

                    if (! $post) {
                        return;
                    }

                    dispatch(new $job(
                        url: url(self::$postURL.'/'.$post->{self::$postSlug}),
                        client: self::$googleAuthType,
                    ));
                });
            }
        }

        FilamentSettingsHub::register([
            SettingHold::make()
                ->page(SeoSettings::class)
                ->order(5)
                ->label('filament-seo::messages.title')
                ->icon('heroicon-o-magnifying-glass')
                ->description('filament-seo::messages.description')
                ->group('filament-settings-hub::messages.group'),
        ]);
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
