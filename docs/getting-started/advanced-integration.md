# Advanced Integration with VueJS

Let's suppose that you want to add on a new administration section in Devise or build in your own VueJS components so that Webpack can do it's thing and optimize your build? Well, we've set it up so that you can do that very easily. This Guide assumes you've setup a [base install of Devise](installation.md).

## What we're going to setup

Devise comes in two parts:
1. The PHP API that ties into Laravel
2. The VueJS frontend that gives you and your content managers a way to interact with that API

What we're going to do here is setup a way for you to recompile the frontend piece with your own Javascript. This is where Devise really shines because it leverages the power of Vue CLI and Webpack to make your bundles as small as possible. So let's get started. Again, this Guide will assume you've setup a [base install of Devise](installation.md).

## Setup Vue CLI

[Vue CLI](https://cli.vuejs.org/) is an _amazing_ utility that will do our compiling for us. Go ahead and follow their [install guide](https://cli.vuejs.org/guide/installation.html) and once you're done you should be able to run ```vue ui``` from your command line and see the UI.

## Create a new Vue Project

On the root of your Laravel project create a new Vue project by clicking the "Create" button. We like to name our projects something like "projectname-interface". 

## Add Devisephp-interface

Once in your project click on the "dependencies" tab and add ```devisephp-interface``` as a dependency. 

## Modify vue.config.js

TODO

## Modify your layouts

TODO
