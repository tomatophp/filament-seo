<?php

namespace TomatoPHP\FilamentSeo\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\SettingsPage;
use Spatie\Sitemap\SitemapGenerator;
use Filament\Forms;
use TomatoPHP\FilamentSeo\Filament\Pages\Traits\HasShield;
use TomatoPHP\FilamentSeo\Jobs\GoogleIndexURLJob;
use TomatoPHP\FilamentSeo\Settings\SeoAppSettings;


class SeoSettings extends SettingsPage
{
    use HasShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = SeoAppSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return trans('filament-seo::messages.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('googleIndex')
                ->visible(fn()=> filament('filament-seo')::$useGoogleIndexing)
                ->requiresConfirmation()
                ->icon('heroicon-o-magnifying-glass-circle')
                ->label(trans('filament-seo::messages.indexing.label'))
                ->form([
                    Forms\Components\TextInput::make('url')
                        ->label(trans('filament-seo::messages.indexing.url'))
                        ->required()
                        ->url()
                ])
                ->action(function (array $data){
                    dispatch(new GoogleIndexURLJob($data['url']));

                    Notification::make()
                        ->title(trans('filament-seo::messages.indexing.title'))
                        ->body(trans('filament-seo::messages.indexing.body'))
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make(trans('filament-seo::messages.google_analytics.title'))
                ->description(trans('filament-seo::messages.google_analytics.description'))
                ->schema([
                    Forms\Components\Toggle::make('seo_use_google_analytics')
                        ->live()
                        ->label(trans('filament-seo::messages.google_analytics.form.use_google_analytics')),
                    Forms\Components\TextInput::make('seo_google_analytics')
                        ->required()
                        ->visible(fn(Forms\Get $get) => $get('seo_use_google_analytics'))
                        ->label(trans('filament-seo::messages.google_analytics.form.use_google_analytics'))
                        ->placeholder('G-XXXXX'),
                ]),

            Forms\Components\Section::make(trans('filament-seo::messages.google_tag_manager.title'))
                ->description(trans('filament-seo::messages.google_tag_manager.description'))
                ->schema([
                    Forms\Components\Toggle::make('seo_use_google_tags_manager')
                        ->live()
                        ->label(trans('filament-seo::messages.google_tag_manager.form.seo_use_google_tags_manager')),
                    Forms\Components\TextInput::make('seo_google_tags_manager')
                        ->required()
                        ->visible(fn(Forms\Get $get) => $get('seo_use_google_tags_manager'))
                        ->label(trans('filament-seo::messages.google_tag_manager.form.seo_use_google_tags_manager'))
                        ->placeholder('GTM-XXXXX'),
                ]),

            Forms\Components\Section::make(trans('filament-seo::messages.google_search_console.title'))
                ->description(trans('filament-seo::messages.google_search_console.description'))
                ->schema([
                    Forms\Components\Toggle::make('seo_use_google_search_console')
                        ->live()
                        ->label(trans('filament-seo::messages.google_search_console.form.seo_use_google_search_console')),
                    Forms\Components\TextInput::make('seo_google_search_console_verification')
                        ->required()
                        ->visible(fn(Forms\Get $get) => $get('seo_use_google_search_console'))
                        ->label(trans('filament-seo::messages.google_search_console.form.seo_google_search_console_verification'))
                        ->placeholder('XXXXX'),
                ]),

            Forms\Components\Section::make(trans('filament-seo::messages.axeptio.title'))
                ->headerActions([
                    Forms\Components\Actions\Action::make('Axeptio')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->url('https://www.axept.io/')
                        ->openUrlInNewTab()
                        ->label(trans('filament-seo::messages.axeptio.title')),
                ])
                ->description(trans('filament-seo::messages.axeptio.description'))
                ->schema([
                    Forms\Components\Toggle::make('seo_use_axeptio')
                        ->live()
                        ->label(trans('filament-seo::messages.axeptio.form.seo_use_axeptio')),
                    Forms\Components\TextInput::make('seo_axeptio_client_id')
                        ->visible(fn(Forms\Get $get) => $get('seo_use_axeptio'))
                        ->label(trans('filament-seo::messages.axeptio.form.seo_axeptio_client_id'))
                        ->required()
                        ->placeholder('XXXXX'),
                    Forms\Components\TextInput::make('seo_axeptio_cookies_version')
                        ->visible(fn(Forms\Get $get) => $get('seo_use_axeptio'))
                        ->label(trans('filament-seo::messages.axeptio.form.seo_axeptio_cookies_version'))
                        ->required()
                        ->placeholder('XXXX-en-EU'),
                ]),
        ];
    }
}
