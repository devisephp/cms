# Devise Installation

## Install Laravel / Composer

Ok, so we expect that you have a Laravel installation somewhere you can work on and have [composer](https://getcomposer.org/doc/00-intro.md) installed globally. If this isn't the case take a look at the [full installation instructions](full-installation-instructions.md)

## Add Devise to Composer

Run the following from your project directory

```$ composer require devisephp/cms:~2.*```

## Run the Devise Installer

Once you have added Devise to your project run the installer which will migrate, seed, and copy a few files necessary to run.

```$ php artisan devise:install```

Most of these questions you can deduce what's happening. However, the last couple involving domains might need some explination. Because Devise is multi-tenant (can host multiple sites on multiple domains) and also is designed to run in multiple environments (development, staging, production) we have to know a few things. Each site has a name and domain which is it's production domain. However, in the .env file of your site we add something like:

```SITE_1_DOMAIN=myamazingsite.test```

This allows Devise to know that when it loads a site off of that domain what you *really* want is ```myamazingsite.com```.

## Once the installer is done

So, once the installer is done a browser should pop open at your domain. Something like: ```http://myamazingsite.test/devise```. This is just a temporary page so that you can login and get started. Head to ```http://myamazingsite.test/login``` (remember to change your URL to whatever you set it up as - NOT myamazingsite.test) and provide the username and password you used during installation. 

Once logged in head back to ```http://myamazingsite.test/devise``` and you will see a couple gears in the top left-hand corner. Click that to go to the admin. What we want to do is the following steps:

1. Create the first template layout file
2. Create our first slice that will appear within that template
3. Register the template in the system
4. Create our homepage and utilize that template

Let's get started.

