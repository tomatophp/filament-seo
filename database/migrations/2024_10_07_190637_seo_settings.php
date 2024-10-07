<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('seo.seo_use_google_analytics', false);
        $this->migrator->add('seo.seo_google_analytics');
        $this->migrator->add('seo.seo_use_google_tags_manager', false);
        $this->migrator->add('seo.seo_google_tags_manager');
        $this->migrator->add('seo.seo_use_axeptio', false);
        $this->migrator->add('seo.seo_axeptio_client_id');
        $this->migrator->add('seo.seo_axeptio_cookies_version');
        $this->migrator->add('seo.seo_use_google_search_console', false);
        $this->migrator->add('seo.seo_google_search_console_verification');
    }

    public function down(): void
    {
        $this->migrator->delete('seo.seo_use_google_analytics');
        $this->migrator->delete('seo.seo_google_analytics');
        $this->migrator->delete('seo.seo_use_google_tags_manager');
        $this->migrator->delete('seo.seo_google_tags_manager');
        $this->migrator->delete('seo.seo_use_axeptio');
        $this->migrator->delete('seo.seo_axeptio_client_id');
        $this->migrator->delete('seo.seo_axeptio_cookies_version');
        $this->migrator->delete('seo.seo_use_google_search_console');
        $this->migrator->delete('seo.seo_google_search_console_verification');
    }
};
