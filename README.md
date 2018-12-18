Laravel Minfraud
===

The simplest library to check if request came from proxy.

Laravel wrapper of `https://github.com/maxmind/minfraud-api-php` with one method

Install
---

Add repository to your `composer.json`:
 
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/mabalashov/laravel-minfraud"
    }
],
```

Install the package:
```
composer require mabalashov/laravel-minfraud
```

Add provider to your `app.php`:
```
LaravelMinfraud\LaravelMinfraudServiceProvider::class
```

Publish the package:
```
php artisan vendor:publish` => `LaravelMinfraud\LaravelMinfraudServiceProvider
```

Change your configs in `config/minfraud.php`:
```
    'account_id' => env('MINFRAUD_ACCOUNT_ID', null),
    'account_key' => env('MINFRAUD_ACCOUNT_KEY', null),

    'max_risk_score' => env('MINFRAUD_MAX_RISK_SCORE', 15),
    'cache_timeout' =>  env('MINFRAUD_CACHE_TIMEOUT', 3600),
```

Add middleware for your requests in `Http\Kernel.php`:
```
protected $middlewareGroups = [
    'web' => [
        // ...
        LaravelMinfraud\Middlewares\MinfraudDenyProxiesMiddleware::class,
    ],
```