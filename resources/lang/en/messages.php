<?php

return [
    "title" => "SEO Settings",
    "description" => "Manage your SEO integration settings",
    "google_analytics" => [
        "title" => "Google Analytics",
        "description" => "Integrate Google Analytics with your website",
        "form" => [
            "use_google_analytics" => "Use Google Analytics",
            "google_analytics" => "Google Analytics ID",
        ],
    ],
    "google_tag_manager" => [
        "title" => "Google Tag Manager",
        "description" => "Integrate Google Tag Manager with your website",
        "form" => [
            "seo_use_google_tags_manager" => "Use Google Tag Manager",
            "seo_google_tags_manager" => "Google Tag Manager ID",
        ],
    ],
    "google_search_console" => [
        "title" => "Google Search Console",
        "description" => "Integrate Google Search Console with your website",
        "form" => [
            "seo_use_google_search_console" => "Use Google Search Console",
            "seo_google_search_console_verification" => "Google Search Console Verification",
        ],
    ],
    "axeptio" => [
        "title" => "Axeptio",
        "description" => "Integrate Axeptio with your website",
        "form" => [
            "seo_use_axeptio" => "Use Axeptio",
            "seo_axeptio_client_id" => "Axeptio Client ID",
            "seo_axeptio_cookies_version" => "Axeptio Cookies Version",
        ],
    ],
    "indexing" => [
        "label" => "Index Link in Google",
        "url" => "URL",
        "title" => "URL Submitted to Google",
        "body" => "The URL has been submitted to Google for indexing.",
    ]
];
