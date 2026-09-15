# Changelog

## v5.0.0

- Support Filament v5 and Laravel 12 / 13 (PHP 8.2+).
- Require `tomatophp/filament-settings-hub` ^5.0, which ships the `settings` table migration: a fresh install migrates without publishing spatie/laravel-settings' migration first (#1, #2).
- Settings page on the v5 `form(Schema $schema)` API.
- `@filamentSEO` renders on every request instead of being baked into the compiled view.
- filament-cms auto indexing is optional: the hooks are skipped when filament-cms is not installed.
- Add `symfony/cache`, used by the Google Search Console client cache.
- Test suite for the plugin, settings page, Google indexing action, directive and install command.
