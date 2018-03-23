# Laravel Ward
###### Manage Your Laravel Log From A Web Dashboard

## Install
```bash
composer require kabbouchi/laravel-ward

php artisan vendor:publish --tag=ward-config

php artisan vendor:publish --tag=ward-assets --force

```

Add WardServiceProvider to the providers array of your Laravel v5.4 application's config/app.php
```php
KABBOUCHI\Ward\Providers\WardServiceProvider::class,
```

Web Dashboard
Laravel Ward's dashboard is inspired by Laravel Horizon. Just like Horizon you can configure authentication to Ward's dashboard. Add the following to the boot method of your AppServiceProvider or wherever you might seem fit.

```php
use KABBOUCCHI\Ward\Ward;

Ward::auth(function($request) {
    // return true / false . For e.g.
    return Auth::check();
});
```

By default Ward's dashboard only works in local environment. To view the dashboard point your browser to /ward of your app or change the `uri` in `config/ward.php`. For e.g. http://laravel.test/ward
