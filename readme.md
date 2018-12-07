# Laravel Nova: Single Record Resource

Adds the ability to create a navigation link directly to the detail page of a resource.
Useful for models that will contain only a single record.

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

Publish the view template:
```
php artisan vendor:publish --tag=nova-views
```

## Important

Laravel Nova currently does not support an integration without overriding the navigation blade template.
Therefore a vendor publish is required with the force flag.
