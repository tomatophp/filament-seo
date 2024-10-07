@if(
    setting('seo_use_google_analytics') &&
    !empty(setting('seo_google_analytics'))
)
<script async src="https://www.googletagmanager.com/gtag/js?id={{setting('seo_google_analytics')}}"></script>
<script>
    function gtag(){dataLayer.push(arguments)}window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","{{setting('seo_google_analytics')}}");
</script>
@endif
