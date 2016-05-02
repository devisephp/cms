Devise
======

[![Latest Stable Version](https://poser.pugx.org/devisephp/cms/v/stable.svg)](https://packagist.org/packages/devisephp/cms)
[![Total Downloads](https://poser.pugx.org/devisephp/cms/downloads.svg)](https://packagist.org/packages/devisephp/cms)
[![Latest Unstable Version](https://poser.pugx.org/devisephp/cms/v/unstable.svg)](https://packagist.org/packages/devisephp/cms)
[![License](https://poser.pugx.org/devisephp/cms/license.svg)](https://packagist.org/packages/devisephp/cms)

![alt text][logo]

##About

Devise is a content management system with rich application development in mind. With full-featured front-end content management Devise supports manipulating images, videos, WYSIWYG editing, maps, audio, "simple" controls such as checkboxes, selects, etc, all by placing simple attribute tags in your html markup.

Furthermore, Devise supports localized content, page versions, no-nonsense html & blade templates, easy to understand permissions, user and group controls, and much much more.

For developers looking to construct a bigger application Devise is a fantastic solution to execute your classes and present data from them right into your templates. No more fussing with controllers or trying to figure out where your logic should go. You focus on your HTML, CSS, and JS and the PHP classes that does your application specific code.

### How To Get Started

There are two ways to get started using Devise. You can either [install on an existing project](http://devisephp.com/docs/installation/#installing-devise-on-an-existing-project) or you can download a clean, build-ready [bootstrap project](https://github.com/devisephp/bootstrap/).

### Full Documentation

Full documentation can be found at [http://devisephp.com/docs](http://devisephp.com/docs)

### General Install

Once you are up and running you can install from either the browser or CLI.

#### Install From Browser

Installing from a browser is very easy. Just go to your domain (http://new-domain.com:8000 in this example - 8000 is the port Homestead listens on) and you will be redirected to the installer

1. Click get started on the welcome screen.

2. Select or set the appropriate environment. This is really up to you and simply sets the name of the environment you are installing to. For instance: If you are working on your own computer you probably want to select "local" and if you're working on the final server you probably want to select "production"

3. Provide the appropriate database settings. If the user you provide has CREATE DATABASE privileges then Devise will create the database for you.

4. Provide the administrators email, username, and password. The password must be at least 8 characters in length.

After clicking next Devise installs it's migrations and seeds into your database and forwards you to the administration screen.

#### Install From Command Line

From the root of your project: ```php artisan devise:install``` and follow the prompts which are very similar to the steps above.

### Testing

Devise has functional and acceptance tests. We have over 500 functional tests.

To run unit tests

```
phpunit
```

To run acceptance tests you will have to bring up a basic devise Laravel application configured to resolve at `http://devisetest.app`. We recommend using https://github.com/devisephp/example but you are welcome to install Devise on any base Laravel 5. In addition to your webserver you will also need to configure a mysql database `devisetest` with user `root` and password `secret`. You can change all of these Codeception settings locally in the [tests/acceptance.suite.yml](https://github.com/devisephp/cms/blob/master/tests/acceptance.suite.yml) config file. Once you have a test server up and running, you may now run codeception acceptance tests with the following command:

```
codecept run acceptance
```

If you would like to run tests inside of firefox instead of phantomjs you will need to first fire up selenium on your local machine with a GUI. To do that, just run this following command...

```
java -jar tests/bootstrap/selenium-server-standalone-2.45.0.jar
```

### Upgrading from 1.3 -> 1.4

Add the following to your applications ```config/app.php``` file:

```
    /*
	    |--------------------------------------------------------------------------
	    | Application Environment
	    |--------------------------------------------------------------------------
	    |
	    | This value determines the "environment" your application is currently
	    | running in. This may determine how you prefer to configure various
	    | services your application utilizes. Set this in your ".env" file.
	    |
	    */

	    'env' => env('APP_ENV', 'production'),
```

As well as update your service providers

```
'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Devise Service Provider...
         */
        Devise\DeviseServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],
```

and your facades:

```
	'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Input' => Illuminate\Support\Facades\Input::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

        /**
         * Devise Aliases
         */
        'Sort'            => Devise\Support\Sortable\SortableFacade::class,
        'DeviseUser'      => Devise\Users\DeviseUser::class,
        'RuleManager'     => Devise\Users\Permissions\RuleManagerFacade::class,
        'Form'            => Collective\Html\FormFacade::class,
        'HTML'            => Collective\Html\HtmlFacade::class,
    ],
```

Update your middleware to utilize the new Devise Middleware for route permissions. We replaced the default values in the array but you can simply add the 'devise.permissions' to the stack if you like.

This file can be found in app/Http/Kernel.php

```
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'devise.permissions' => \Devise\Pages\Http\Middleware\Permissions::class,
    ];
```

### Upgrading from 1.4 -> 1.5

After composer has completed

```
    php artisan devise:upgrade
```

###License

Devise is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

[logo]: https://raw.githubusercontent.com/devisephp/cms/master/project-banner.png "Devise Logo"
