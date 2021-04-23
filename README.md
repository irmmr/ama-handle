<p align="center">
    <a href="https://packagist.org/packages/irmmr/handle" target="_blank">
        <img src="https://img.shields.io/packagist/v/irmmr/handle?style=flat" alt="packagist"/>
    </a>
    <a href="https://github.com/irmmr/ama-handle/blob/main/LICENSE" target="_blank">
        <img src="https://img.shields.io/github/license/irmmr/ama-handle?style=flat" alt="license"/>
    </a>
    <img src="https://img.shields.io/packagist/php-v/irmmr/handle/V1.0.2?style=flat" alt="php version support"/>
    <img src="https://img.shields.io/badge/stable-V1.1.2-red?style=flat" alt="stable version"/>
</p>

# What is ama-handle?
A library with which you can use a series of ready-made functions and classes to make your coding task easier. This handle uses different packages and classes.

# Install
You can use `Composer` to install this library. If you want to use this library, it is better to always use the latest version or stable versions.
```
composer require irmmr/handle
```
```json
{
    "require": {
        "irmmr/handle": "^1.0"
    }
}
```

# Error reporting
You can manage errors that occur in the handle, but note that this only includes errors that have already been specified.
This section contains two items, but you only need to specify a listener.
```php
use Irmmr\Handle\App\Err;

// listen database errors
Err::listen(ERROR_TYPE, function ($error) {
    if (is_null($error)) return;
    echo $error->getMessage();
});
```
> The error type is **Irmmr\Handle\App\Exception\Main**, which is a instance of **\Exception**.

# Use
If you are ready to use the library, you can use all the classes in folder `/src`. There are no restrictions on the use of these items and they are constantly updated.

- Working with data
```php
use Irmmr\Handle\Data as D;

// Remove from string . return: Homan!
echo D::remove()->str('Hello man!', 'e', 'l', ' ');

// Remove from string. return: Homan!
echo D::remove()->strFormat('Hello man!', '/[el ]/');
```

- Working with import
```php
use Irmmr\Handle\Package as Pack;
use Irmmr\Handle\Data;

// example import with require
// `import` scans all php files in `my-dir`
Pack::import('test.php', 'file.php', 'my-dir')
    ->base(__DIR__)->do();

// block some files
Pack::import('one-dir')
    ->base(__DIR__, 'include')
    ->filter(function ($file) {
        return !Data::check()->includes($file, '/vendor/');
    })->do();
```

- Working with method
```php
use Irmmr\Handle\Method;

// get method type
echo Method::type();

// check method type
if (Method::isType(Method::GET)) {
    echo 'It\'s GET.';
}

// check and get a sample GET method
if (Method::get()->has('page')) {
    $page = Method::get()->get('page');
} else {
    $page = 1;
}

// or
$page = Method::get()->get('page') ?? 1;

// or with default value
$page = Method::get()->get('page', 1);
```

- Working with file
```php
use Irmmr\Handle\Filer as F;

// get file size
echo F::file()->size('path.txt');

// make dir
F::dir()->make('my-dir');
```

And other items that will be added later.
