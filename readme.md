# Laravel Nova: Single Record Resource
[![License](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/daniel-de-wit/nova-single-record-resource)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/daniel-de-wit/nova-single-record-resource.svg?style=flat-square)](https://packagist.org/packages/daniel-de-wit/nova-single-record-resource)
[![Total Downloads](https://img.shields.io/packagist/dt/daniel-de-wit/nova-single-record-resource.svg?style=flat-square)](https://packagist.org/packages/daniel-de-wit/nova-single-record-resource)
[![StyleCI](https://github.styleci.io/repos/160710362/shield?branch=master)](https://github.styleci.io/repos/160710362)

Adds the ability to create a navigation link directly to the detail page of a resource.
Useful for models that will contain only a single record.

![](https://github.com/daniel-de-wit/nova-single-record-resource/raw/master/demo.gif)

## Prerequisites
 - [Laravel](https://laravel.com/)
 - [Laravel Nova](https://nova.laravel.com/)

## Installation

```
$ composer require daniel-de-wit/nova-single-record-resource
```

Modify `app/Nova/Resource.php` to implement `SingleRecordResourceInterface` and the `SupportSingleRecordNavigationLinks` trait:

```php
<?php

namespace App\Nova;

use DanielDeWit\NovaSingleRecordResource\Contracts\SingleRecordResourceInterface;
use DanielDeWit\NovaSingleRecordResource\Traits\SupportSingleRecordNavigationLinks;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource implements SingleRecordResourceInterface
{
    use SupportSingleRecordNavigationLinks;

    ...
}
```

Publish assets:
```
$ php artisan vendor:publish --provider="DanielDeWit\NovaSingleRecordResource\Providers\NovaSingleRecordResourceServiceProvider"
```


## Update

When updating it is important to republish the assets, like so:

```
$ php artisan vendor:publish --force --provider="DanielDeWit\NovaSingleRecordResource\Providers\NovaSingleRecordResourceServiceProvider"
```


## Uninstallation

Remove from composer

```
$ composer remove daniel-de-wit/nova-single-record-resource
```

Remove `SupportSingleRecordNavigationLinks` trait from your Nova Resources

```
use SupportSingleRecordNavigationLinks;
```

Remove the customized navigation template

```
rm resources/views/vendor/nova/resources/navigation.blade.php
```

## Usage

Place the following method on models that have only a single record.

```php
class MyResource extends Resource
{
    public static function singleRecord(): bool
    {
        return true;
    }
}
```

Optionally override the resource identifier.

```php
class MyResource extends Resource
{
    /**
     * @return string|int
     */
    public static function singleRecordId()
    {
        return 1;
    }
}
```

## How it works

Laravel Nova has the ability to override the Blade template used to render the navigation sidebar.
The template is copied from Nova version v1.2.0 and altered with a few lines to support linking a resource directly to the detail view.
When publishing vendor assets with the tag `nova-views` the template will be placed in the project `resources/views/vendor/nova/resources` folder.

<details>
<summary>View changes</summary>

```php
@if ($resource::singleRecord())
    <router-link :to="{
    name: 'detail',
    params: {
        resourceName: '{{ $resource::uriKey() }}',
        resourceId: {{ $resource::singleRecordId() }}
    }
}" class="text-white text-justify no-underline dim">
        {{ $resource::label() }}
    </router-link>
@else
    <router-link :to="{
    name: 'index',
    params: {
        resourceName: '{{ $resource::uriKey() }}'
    }
}" class="text-white text-justify no-underline dim">
        {{ $resource::label() }}
    </router-link>
@endif
```
</details>
