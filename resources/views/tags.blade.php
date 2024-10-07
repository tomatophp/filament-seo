<meta name="description" content="@yield('description', app()->getLocale() === 'en' ? str(setting('site_description'))->explode('|')[0]??setting('site_description') : str(setting('site_description'))->explode('|')[1]??setting('site_description'))">
<meta name="keywords" content="@yield('keywords', setting('site_keywords'))">
<meta name="author" content="@yield('author', setting('site_author'))">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{url()->current()}}" />
<title>@yield('title', app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name'))</title>
<meta property='article:published_time' content='@yield('date', \Carbon\Carbon::now()->toDateTimeString())'>
<meta property='article:section' content='@yield('category', 'news')'>

<meta property="og:site_name" content="{{ app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name') }}">
<meta property="og:type" content="@yield('type', 'website')" />
<meta property="og:locale" content="ar-eg" />
<meta property="og:locale:alternate" content="en-us">
<meta property="og:title" content="@yield('title', app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name'))" />
<meta property="og:description" content="@yield('description', app()->getLocale() === 'en' ? str(setting('site_description'))->explode('|')[0]??setting('site_description') : str(setting('site_description'))->explode('|')[1]??setting('site_description'))" />
<meta property="og:image" content="@yield('image', url('storage/' . setting('site_profile')))" />
<meta property="og:image:alt" content="@yield('title', app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name'))" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:site_name" content="{{app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name')}}" />

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="@yield('title', app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name'))">
<meta name="twitter:description" content="@yield('description', app()->getLocale() === 'en' ? str(setting('site_description'))->explode('|')[0]??setting('site_description') : str(setting('site_description'))->explode('|')[1]??setting('site_description'))">
<meta name="twitter:image" content="@yield('image', url('storage/' . setting('site_profile')))">


<script type="application/ld+json">{"@context":"https://schema.org","@type":"Article","name":"@yield('title', app()->getLocale() === 'en' ? str(setting('site_name'))->explode('|')[0]??setting('site_name') : str(setting('site_name'))->explode('|')[1]??setting('site_name'))"}</script>
