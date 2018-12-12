# Laravel Nova: Single Record Resource

Adds the ability to create a navigation link directly to the detail page of a resource.
Useful for models that will contain only a single record.

![](https://github.com/daniel-de-wit/nova-single-record-resource/blob/master/demo.gif)

## Prerequisites
 - [Laravel](https://laravel.com/)
 - [Laravel Nova](https://nova.laravel.com/)

## Installation

```
$ composer require daniel-de-wit/nova-single-record-resource
```

Modify `app/Nova/Resource.php` to implement `SingleRecordResourceInterface` and the `SingleRecord` trait:

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
    public static function singleRecordId(): bool
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
        resourceId: {{ $resource::firstRecordId() }}
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
