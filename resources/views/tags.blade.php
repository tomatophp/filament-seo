<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{url()->current()}}" />
<title>{{ $title }}</title>
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
