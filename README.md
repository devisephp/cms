# Devise

## What is Devise?
Devise is a content management solution that allows developers use a combination of VueJS and Laravel Blade documents to create page "slices" that are just parts of what make up a webpage. Those slices can then be implemented in any order and configuration by content managers throughout their site without the need for a developer. This allows developers to work with their clients and designers in a very iterative way to grow their site incrementally, add new features with ease, and test different page layouts to find the one that is most successful.

## Get Started
Installation to get started with Devise is very easy for a basic installation. For more advanced customization please refer to the [documentation](https://devise.gitbook.io/cms/).

<<<<<<< HEAD
## About
=======
### Basic installation steps
>>>>>>> v2-dev

While you can develop in any PHP 7.1 environment this assumes you are using [Laravel Valet](https://laravel.com/docs/5.8/valet) and have [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) composer setup correctly.

#### Create a new Laravel Project

```
composer create-project --prefer-dist laravel/laravel my-devise-project
```

#### Install Devise

```
cd my-devise-project
composer require devisephp/cms
```

#### Publish Assets

```
php artisan vendor:publish --tag=dvs-assets
```

#### Finish Install Wizard

Now you can visit your site at ```http://my-devise-project.test``` and finish the install wizard. The wizard will update automatically as you complete various tasks. When creating your first user you will be logged in as that user and once complete will see the editor on the left side of the screen.

#### What Now?

If you followed the wizard exactly you will be presented with that first test slice that you created. It's pretty boring but serves as a good boilerplate for other slices. Take a look at your design. See what repeats, what can be used in multiple places. Those natural lines help define which slices you should probably create.

For guidance on slice creation take a look at how we build the [Devise Marketing](https://github.com/devisephp/marketing) site and, of course, the [documentation](https://devise.gitbook.io/cms/).

## Contributing

<<<<<<< HEAD
### License
=======
We welcome pull requests and issues with open arms. However, please take a quick look at our contribution guidelines so that you can quick get up and running building Devise in the appropriate environment and so that your issues get resolved as quickly as possible.
>>>>>>> v2-dev

## License

Devise is available under the [MIT license](http://opensource.org/licenses/MIT).
