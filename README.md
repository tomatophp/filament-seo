![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-seo/master/arts/3x1io-tomato-seo.jpg)

# Filament SEO

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-seo/version.svg)](https://packagist.org/packages/tomatophp/filament-seo)
[![License](https://poser.pugx.org/tomatophp/filament-seo/license.svg)](https://packagist.org/packages/tomatophp/filament-seo)
[![Downloads](https://poser.pugx.org/tomatophp/filament-seo/d/total.svg)](https://packagist.org/packages/tomatophp/filament-seo)

Manage and generate SEO tags and integrate your website with Google SEO services

## Installation

```bash
composer require tomatophp/filament-seo
```
after install your package please run this command

```bash
php artisan filament-seo:install
```

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(
    \TomatoPHP\FilamentSeo\FilamentSeoPlugin::make()
)
```

on your `.env` add `GOOGLE_CREDENTIALS` to the path of your google admin service credentials file, please make sure that the account has access to [Indexing API](https://developers.google.com/search/apis/indexing-api/v3/quickstart) and [Search Console API](https://developers.google.com/webmaster-tools/about)

```dotenv
GOOGLE_CREDENTIALS=
```

## Screenshots

![Setting](https://raw.githubusercontent.com/tomatophp/filament-seo/master/arts/setting.png)
![Indexing](https://raw.githubusercontent.com/tomatophp/filament-seo/master/arts/indexing.png)

## Features

- [x] CMS builder auto indexing
- [x] Generate SEO tags
- [x] Generate Open Graph tags
- [x] Generate Twitter tags
- [x] Generate JSON-LD tags
- [x] Integrate with Google Indexing API
- [x] Integrate with Google Search Console API
- [x] Integrate with Google Analytics
- [x] Integrate with Google Tag Manager
- [x] Integrate with [Axeptio](https://www.axept.io/)
- [ ] Integrate with Meta Pixel
- [ ] Integrate with X Business ads

## Using

you can just add this blade directive to your head of your layout

```html
@filamentSeo
```

it will integrate everything for you and when you extend this layout you can use this sections

```html
@section('title', 'PAGE TITLE')
@section('description', 'PAGE DESCRIPTION')
@section('keywords', 'PAGE KEYWORDS')
@section('image', 'PAGE IMAGE')
@section('author', 'PAGE AUTHOR')
```

## Allow CMS Builder Auto Indexing

we are integrate with [CMS Builder](https://github.com/tomatophp/filament-cms) to allow auto indexing for your pages, to allow this feature make sure you install `filament-cms` then allow this feature by use this method


```php
->plugin(
    \TomatoPHP\FilamentSeo\FilamentSeoPlugin::make()
        ->allowAutoPostsIndexing()
        ->postUrl('/blog') // your post url
        ->postSlug('slug') // your post slug or id
)
```

## Use Google Indexing Jobs

we have a jobs to make it easy to integrate google indexing API on your Site like this

```php
dispatch(new \TomatoPHP\FilamentSeo\Jobs\GoogleIndexURLJob([
    'url' => 'https://example.com'
]));

dispatch(new \TomatoPHP\FilamentSeo\Jobs\GoogleRemoveIndexURLJob([
    'url' => 'https://example.com'
]));
```

## Use Filament Shield

you can use the shield to protect your resource and allow user roles by install it first

```bash
composer require bezhansalleh/filament-shield
```

Add the Spatie\Permission\Traits\HasRoles trait to your User model(s):

```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    // ...
}
```
Publish the config file then setup your configuration:

```php
->plugin(\BezhanSalleh\FilamentShield\FilamentShieldPlugin::make())
```

Now run the following command to install shield:

```bash
php artisan shield:install
```

Now we can [publish the package assets]([https://github.com/bezhanSalleh/filament-shield](https://github.com/tomatophp/filament-users?tab=readme-ov-file#publish-assets)).

```bash
php artisan vendor:publish --tag="filament-users-config"
```

now you need to allow it on the plugin options

```php
->plugin(\TomatoPHP\FilamentCms\FilamentCMSPlugin::make()->allowShield())
```

for more information check the [Filament Shield](https://github.com/bezhanSalleh/filament-shield)

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-seo-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-seo-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-seo-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-seo-migrations"
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
