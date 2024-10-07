@if(
    setting('seo_use_google_search_console') &&
    !empty(setting('seo_google_search_console_verification'))
)
    <meta name="google-site-verification" content="{{ setting('seo_google_search_console_verification') }}">
@endif

