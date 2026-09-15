<?php

namespace TomatoPHP\FilamentSeo\Filament\Pages\Traits;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

trait HasShield
{
    public function booted(): void
    {
        if (filament('filament-seo')->isShieldAllowed()) {
            $this->beforeBooted();

            if (! static::canAccess()) {

                Notification::make()
                    ->title(__('filament-shield::filament-shield.forbidden'))
                    ->warning()
                    ->send();

                $this->beforeShieldRedirects();

                redirect($this->getShieldRedirectPath());

                return;
            }

            if (method_exists(parent::class, 'booted')) {
                parent::booted();
            }

            $this->afterBooted();
        }
    }

    protected function beforeBooted(): void {}

    protected function afterBooted(): void {}

    protected function beforeShieldRedirects(): void {}

    protected function getShieldRedirectPath(): string
    {
        return Filament::getUrl();
    }

    /**
     * Same page permission name as filament-settings-hub (filament-shield 4+), only when filament-shield is installed.
     */
    protected static function getPermissionName(): string
    {
        if (! class_exists('BezhanSalleh\FilamentShield\Support\Utils')) {
            return '';
        }

        return Str::of(class_basename(static::class))
            ->prepend('View:')
            ->toString();
    }

    public static function canAccess(): bool
    {
        if (filament('filament-seo')->isShieldAllowed()) {
            return Filament::auth()->user()->can(static::getPermissionName());
        } else {
            return true;
        }
    }
}
