# Full Installation

## You're New. Welcome!

First, getting your development environment setup is, by far, the most complicated part of this equation. But stick with it. Once you're good to go you're really going to enjoy working with both Devise and Laravel.

## Development Environments

You need to ensure you have an appropriate environment to work in. Most Laravel developers lean on one of three options:

* [Valet](https://laravel.com/docs/5.6/valet) (Mac OS Only)
* [Homestead](https://laravel.com/docs/5.6/homestead) (Windows, Mac, Linux)
* [Artisan](https://laravel.com/docs/5.6/installation)

If you're on a Mac then you should note that the primary difference (for us anyway) is that [Homestead](https://laravel.com/docs/5.6/homestead) uses virtual machines via Vagrant. This is fine for desktop machines but if you're out an about on a laptop you may want to look at [Valet](https://laravel.com/docs/5.6/valet) due to battery performance. Honestly, both of the first two options are amazing solutions we use every day.

Neither of us have much experience using Laravel's built-in artisan server (option 3) but if you have PHP installed... maybe give it a go. Just keep in mind you'll need a Laravel supported database also running for Devise

## Installing Laravel

We'd highly suggest that you install the [Laravel Installer](https://laravel.com/docs/5.6/installation). Once that's installed you can do a simple command like:

```laravel new deviseproject```

This will create a new Laravel application directory.

## Congratulations!

If you're seeing the Laravel welcome screen you can move on to the [Devise Installation Instructions](devise-installation-instructions.md)
