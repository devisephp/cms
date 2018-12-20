# Getting Started with Devise

## A Quick Overview

Well, you are here! Thank you for taking the time to check out Devise, we think you're really going to enjoy your experience with it. So, how do you get started? Essentially, there are two ways to integrate Devise:

1. A simple install which allows you to use the base features of Devise by including the CSS and pre-compiled JavaScript file. It's quick, easy, and will be ready to go in no time.

2. A _slightly_ more complex installation will allow you to completely customize Devise's administration, add new controls, and change... well.. essentially anything you want.

## Required Steps for Any Installation

#### Create your project

Get started by installing a fresh copy of Laravel by using composer on your local machine

```
composer create-project --prefer-dist laravel/laravel project-folder-name
```

#### Install Devise

After composer has done it's thing install the Devise Package as a dependency

```
composer require devisephp/cms
```

#### Publish assets

Publish the Devise assets. This includes the base Devise JavaScript and CSS needed to run

```
php artisan vendor:publish --tag dvs-assets
```

#### Edit your .env

Next we need to connect to the database. Edit the .env file in the root of your project and point it at your database focusing on the following entries:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projectdatabasename
DB_USERNAME=root
DB_PASSWORD=sUp3r371teP@ssw0rd
```

#### Migrate your database

Your database will need to be populated with some base tables for Devise to run. Run the following command from the root of your project:

```
php artisan migrate
```

#### Visit the site

At this point you should be able to visit your project through a browser and see the install screen. If you're using valet it should be the folder name will be the domain followed by a `.test` by default. With Homestead it's whatever you mapped the domain to.

When you reach your site you should see something similar to what is below:

![Installer Screen](https://github.com/devisephp/cms/raw/v2-dev/docs/imgs/installer.png "Installer Screen")

The Devise installer is a guided install that updates every few seconds. Additionally, it provides forms to create new users, sites, etc. There are two main sections to the installer:

1. Required - Once these are complete you can move forward

2. Suggested - We would highly suggest knocking these out as well. These will help clean up some routes and also provide some additional features for Devise.

## A note on viewing your installation

You will need some sort of web server running on your local machine. If you are new to this might we suggest using one of Laravel's two amazing solutions:

### Valet

Valet provides a very quick way of getting a development environment running on your Mac. It's efficient, light on your battery and easy to update.

(https://laravel.com/docs/5.7/valet)[Homestead]

### Homestead

A Windows or Mac solution that runs on a Vagrent box. It's a great solution but will eat your battery if you're running on a laptop. However, having a sandboxed environment can be awesome.

(https://laravel.com/docs/5.7/homestead)[Homestead]
