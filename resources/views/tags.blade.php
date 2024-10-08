@php
    $sections = app()->view->getSections();

    $title = isset($sections['title']) ? $sections['title'] : multiLang(setting('site_name'));
    $description = isset($sections['description']) ? $sections['description'] : multiLang(setting('site_description'));
    $keywords = isset($sections['keywords']) ? $sections['keywords'] : multiLang(setting('site_keywords'));
    $author = isset($sections['author']) ? $sections['author'] : multiLang(setting('site_author'));
    $image = isset($sections['image']) ? $sections['image'] : url('storage/' . setting('site_profile'));
    $type = isset($sections['type']) ? $sections['type'] : 'website';
    $category = isset($sections['category']) ? $sections['category'] : 'news';
    $date = isset($sections['date']) ? $sections['date'] : \Carbon\Carbon::now()->toDateTimeString();

    function multiLang($value){
        return app()->getLocale() === 'en' ? str($value)->explode('|')[0]??$value : str($value)->explode('|')[1]??$value;
    }
@endphp

<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{url()->current()}}" />
<title>@yield('title', $title)</title>
<meta property='article:published_time' content='{{ $date }}'>
<meta property='article:section' content='{{ $category }}'>

<meta property="og:site_name" content="{{ setting('site_name') }}">
<meta property="og:type" content="{{ $type }}" />
<meta property="og:locale" content="ar-eg" />
<meta property="og:locale:alternate" content="en-us">
<meta property="og:title" content="{{ $title }}" />
<meta property="og:description" content="{{ $description }}" />
<meta property="og:image" content="{{ $image }}" />
<meta property="og:image:alt" content="{{ $title }}" />
<meta property="og:url" content="{{url()->current()}}" />

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">


<script type="application/ld+json">{"@context":"https://schema.org","@type":"{{ $type }}","name":"{{ $title }}"}</script>
