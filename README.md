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

To run acceptance tests you will have to start Laravel server

- `cd tests/bootstrap`
- `composer install`.
- `php artisan serve`
- `cd ../..`

Finally run codeception acceptance tests. This checks a lot of the devise front-end editor and javascript.

- `codecept run acceptance`

###License

Devise is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

[logo]: https://raw.githubusercontent.com/devisephp/cms/master/project-banner.png "Devise Logo"
