@if(
    setting('seo_use_axeptio') &&
    !empty(setting('seo_axeptio_client_id')) &&
    !empty(setting('seo_axeptio_cookies_version'))
)
<script>
    window.axeptioSettings={clientId:"{{setting('seo_axeptio_client_id')}}",cookiesVersion:"{{setting('seo_axeptio_cookies_version')}}",googleConsentMode:{default:{analytics_storage:"denied",ad_storage:"denied",ad_user_data:"denied",ad_personalization:"denied",wait_for_update:500}}},function(e,t){var a=e.getElementsByTagName(t)[0],n=e.createElement(t);n.async=!0,n.src="//static.axept.io/sdk.js",a.parentNode.insertBefore(n,a)}(document,"script");
</script>
@endif

