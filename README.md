<p align="center">
    <a href="https://packagist.org/packages/irmmr/handle" target="_blank">
        <img src="https://img.shields.io/packagist/v/irmmr/handle?style=flat" alt="packagist"/>
    </a>
    <a href="https://github.com/irmmr/ama-handle/blob/main/LICENSE" target="_blank">
        <img src="https://img.shields.io/github/license/irmmr/ama-handle?style=flat" alt="license"/>
    </a>
    <img src="https://img.shields.io/packagist/php-v/irmmr/handle/V1.0.2?style=flat" alt="php version support"/>
    <img src="https://img.shields.io/badge/stable-V1.0.7-red?style=flat" alt="stable version"/>
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


# Config
This library includes a config folder where you can change various settings including email and database for your personal use.

> Sample config file : **/config/database.php**
```php
return [
    'user'      => 'my-database-user',
    'pass'      => 'my-database-password',
    'name'      => 'my-database-name',
    'host'      => 'localhost',
    'charset'   => 'utf8',
    'auto_make' => true,
];
```


# Error reporting
You can manage errors that occur in the handle, but note that this only includes errors that have already been specified.
This section contains two items, but you only need to specify a listener.
```php
use Irmmr\Handle\App\Err;

// listen database errors
Err::listen(Err::DATABASE, function ($error) {
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

- Working with database
```php
use Irmmr\Handle\Db;

// Database select 1
Db::query()->table('my-table')->select(['id', 'name'])->where(['user' => 'ot'])->get();

// Database select 2
Db::getData('SELECT `id`, `name` FROM `my-table` WHERE `user`=:user', [
    'user' => 'ot'
]);
```

And other items that will be added later.
