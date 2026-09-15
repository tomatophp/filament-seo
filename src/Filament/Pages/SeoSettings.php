<?php

namespace TomatoPHP\FilamentSeo\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use TomatoPHP\FilamentSeo\Filament\Pages\Traits\HasShield;
use TomatoPHP\FilamentSeo\FilamentSeoPlugin;
use TomatoPHP\FilamentSeo\Jobs\GoogleIndexURLJob;
use TomatoPHP\FilamentSeo\Settings\SeoAppSettings;

class SeoSettings extends SettingsPage
{
    use HasShield;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog';

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
            Action::make('googleIndex')
                ->visible(fn (): bool => FilamentSeoPlugin::$useGoogleIndexing)
                ->requiresConfirmation()
                ->icon('heroicon-o-magnifying-glass-circle')
                ->label(trans('filament-seo::messages.indexing.label'))
                ->schema([
                    TextInput::make('url')
                        ->label(trans('filament-seo::messages.indexing.url'))
                        ->required()
                        ->url(),
                ])
                ->action(function (array $data): void {
                    dispatch(new GoogleIndexURLJob($data['url'], FilamentSeoPlugin::$googleAuthType));

                    Notification::make()
                        ->title(trans('filament-seo::messages.indexing.title'))
                        ->body(trans('filament-seo::messages.indexing.body'))
                        ->success()
                        ->send();
                }),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(trans('filament-seo::messages.google_analytics.title'))
                    ->description(trans('filament-seo::messages.google_analytics.description'))
                    ->schema([
                        Toggle::make('seo_use_google_analytics')
                            ->live()
                            ->label(trans('filament-seo::messages.google_analytics.form.use_google_analytics')),
                        TextInput::make('seo_google_analytics')
                            ->required()
                            ->visible(fn (Get $get): bool => (bool) $get('seo_use_google_analytics'))
                            ->label(trans('filament-seo::messages.google_analytics.form.use_google_analytics'))
                            ->placeholder('G-XXXXX'),
                    ]),

                Section::make(trans('filament-seo::messages.google_tag_manager.title'))
                    ->description(trans('filament-seo::messages.google_tag_manager.description'))
                    ->schema([
                        Toggle::make('seo_use_google_tags_manager')
                            ->live()
                            ->label(trans('filament-seo::messages.google_tag_manager.form.seo_use_google_tags_manager')),
                        TextInput::make('seo_google_tags_manager')
                            ->required()
                            ->visible(fn (Get $get): bool => (bool) $get('seo_use_google_tags_manager'))
                            ->label(trans('filament-seo::messages.google_tag_manager.form.seo_use_google_tags_manager'))
                            ->placeholder('GTM-XXXXX'),
                    ]),

                Section::make(trans('filament-seo::messages.google_search_console.title'))
                    ->description(trans('filament-seo::messages.google_search_console.description'))
                    ->schema([
                        Toggle::make('seo_use_google_search_console')
                            ->live()
                            ->label(trans('filament-seo::messages.google_search_console.form.seo_use_google_search_console')),
                        TextInput::make('seo_google_search_console_verification')
                            ->required()
                            ->visible(fn (Get $get): bool => (bool) $get('seo_use_google_search_console'))
                            ->label(trans('filament-seo::messages.google_search_console.form.seo_google_search_console_verification'))
                            ->placeholder('XXXXX'),
                    ]),

                Section::make(trans('filament-seo::messages.axeptio.title'))
                    ->headerActions([
                        Action::make('Axeptio')
                            ->icon('heroicon-o-arrow-top-right-on-square')
                            ->url('https://www.axept.io/')
                            ->openUrlInNewTab()
                            ->label(trans('filament-seo::messages.axeptio.title')),
                    ])
                    ->description(trans('filament-seo::messages.axeptio.description'))
                    ->schema([
                        Toggle::make('seo_use_axeptio')
                            ->live()
                            ->label(trans('filament-seo::messages.axeptio.form.seo_use_axeptio')),
                        TextInput::make('seo_axeptio_client_id')
                            ->visible(fn (Get $get): bool => (bool) $get('seo_use_axeptio'))
                            ->label(trans('filament-seo::messages.axeptio.form.seo_axeptio_client_id'))
                            ->required()
                            ->placeholder('XXXXX'),
                        TextInput::make('seo_axeptio_cookies_version')
                            ->visible(fn (Get $get): bool => (bool) $get('seo_use_axeptio'))
                            ->label(trans('filament-seo::messages.axeptio.form.seo_axeptio_cookies_version'))
                            ->required()
                            ->placeholder('XXXX-en-EU'),
                    ]),
            ]);
    }
}
