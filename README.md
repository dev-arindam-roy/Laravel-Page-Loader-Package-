# Laravel Page Loader Package-
### A package for customize page loading system in easiest way. Just install it

## Installation

> **No dependency on PHP version and LARAVEL version**

### STEP 1: Run the composer command:

```shell
composer require creative-syntax/page-loader
```

### STEP 2: Laravel without auto-discovery:

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
CreativeSyntax\PageLoader\CSPageLoader::class,
```

### STEP 3: Publish the package config: (If you want to customize)

```php
php artisan vendor:publish --provider="CreativeSyntax\PageLoader\CSPageLoader" --force

-OR-

php artisan vendor:publish --tag="page-loader:config"
```

## customization like:

> **in config folder, you will get a file -page-loader.php**
---

```php
return [
    'is-active' => true, // if false then disable the loader
    'color' => '#0277BD' // you can change the color of the loader
];
```


## license:
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Post Issues: if found any
If have any issue please [write me](https://github.com/dev-arindam-roy/Laravel-Page-Loader-Package-/issues).


