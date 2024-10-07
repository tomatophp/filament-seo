<?php

namespace TomatoPHP\FilamentSeo;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use TomatoPHP\FilamentCms\Events\PostCreated;
use TomatoPHP\FilamentCms\Events\PostDeleted;
use TomatoPHP\FilamentCms\Events\PostUpdated;
use TomatoPHP\FilamentCms\Models\Post;
use TomatoPHP\FilamentSeo\Facades\FilamentSeo;
use TomatoPHP\FilamentSeo\Jobs\GoogleIndexURLJob;
use TomatoPHP\FilamentSeo\Jobs\GoogleRemoveIndexURLJob;
use TomatoPHP\FilamentSeo\Filament\Pages\SeoSettings;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

class FilamentSeoPlugin implements Plugin
{
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
           SeoSettings::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        if(self::$allowAutoPostsIndexing){
            Event::listen(PostCreated::class, function ($event){
                $post = Post::query()->find($event->data['id']);

                dispatch(new GoogleIndexURLJob(
                    url: url(self::$postURL . '/' . $post->{self::$postSlug}),
                    client: self::$googleAuthType
                ));
            });

            Event::listen(PostUpdated::class, function ($event){
                $post = Post::query()->find($event->data['id']);

                dispatch(new GoogleIndexURLJob(
                    url: url(self::$postURL . '/' . $post->{self::$postSlug}),
                    client: self::$googleAuthType
                ));
            });

            Event::listen(PostDeleted::class, function ($event){
                $post = Post::query()->find($event->data['id']);

                dispatch(new GoogleRemoveIndexURLJob(
                    url: url(self::$postURL . '/' . $post->{self::$postSlug}),
                    client: self::$googleAuthType
                ));
            });
        }


        FilamentSettingsHub::register([
            SettingHold::make()
                ->page(SeoSettings::class)
                ->order(5)
                ->label('filament-seo::messages.title')
                ->icon('heroicon-o-magnifying-glass')
                ->description('filament-seo::messages.description')
                ->group('filament-settings-hub::messages.group')
        ]);
    }

    public static function make(): static
    {
        return new static();
    }
}
