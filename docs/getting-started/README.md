# Getting Started with Devise

## A Quick Overview

Well, you are here! Thank you for taking the time to check out Devise, we think you're really going to enjoy your experience with it. So, how do you get started? Essentially, there are two ways to integrate Devise:

1. A [simple install](installation.md) which allows you to use the base features of Devise by including the CSS and pre-compiled JavaScript file. It's quick, easy, and will be ready to go in no time.

2. A _slightly_ more [complex installation](advanced-integration.md) will allow you to completely customize Devise's administration, add new controls, and change... well.. essentially anything you want.

# Getting your Development Environment Ready

If you're new to Laravel or PHP take a look below. We have some suggestions and resources that will get you up and running in no time.

## Development Environments

Regardless if you use Devise out of the box or integrate it with your own javascript solutions you need to ensure you have an appropriate environment to work in. Most Laravel developers lean on one of three options:

- [Valet](https://laravel.com/docs/5.6/valet) (Mac OS Only)
- [Homestead](https://laravel.com/docs/5.6/homestead) (Windows, Mac, Linux)
- [Artisan](https://laravel.com/docs/5.6/installation)

If you're on a Mac then you should note that the primary difference (for us anyway) is that [Homestead](https://laravel.com/docs/5.6/homestead) uses virtual machines via Vagrant. This is fine for desktop machines but if you're out an about on a laptop you may want to look at [Valet](https://laravel.com/docs/5.6/valet) due to battery performance. Honestly, both of the first two options are amazing solutions we use every day.

We don't have much experience using Laravel's built-in artisan server (option 3) but if you have PHP installed... maybe give it a go. Just keep in mind you'll need a Laravel supported database also running for Devise