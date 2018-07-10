# Devise Installation

## Install Laravel / Composer

Ok, so we expect that you have a Laravel installation somewhere you can work on and have [composer](https://getcomposer.org/doc/00-intro.md) installed globally. If this isn't the case take a look at the [full installation instructions](full-installation-instructions.md)

## Add Devise to Composer

Run the following from your project directory

```$ composer require devisephp/cms:~2.*```

## Run the Devise Installer

Once you have added Devise to your project run the installer which will migrate, seed, and copy a few files necessary to run.

```$ php artisan devise:install```

## Create your first template layout

Now, this can go all sorts of ways but for the most part Devise works essentially the same as Laravel's blade system. In fact, it uses blade files for your layouts and slices. More on layouts and slices in the "How Devise Works" section but for now let's just create a simple layout in ```/resources/views/master.blade.php```. 

```
<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    @isset($page)
    {!! Devise::head($page) !!}
    @else
    {!! Devise::head() !!}
    @endif
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to Devise</title>
  </head>
  <body class="text-grey-darker">

    <div id="app">
      <devise>

        <div slot="on-top"></div>

        <div slot="static-content">
          @yield('content')
        </div>

        <!-- <div slot="static-content-bottom">
          @yield('content')
        </div> -->
        
        <div slot="on-bottom"></div>

      </devise>
    </div>

    <script src="{{mix('/manifest.js', './devise')}}"></script>
    <script src="{{mix('/js/devise.js', './devise')}}"></script>

  </body>
</html>
```

Let's break this down:

1. First, the head contains a ```Devise::head()``` call that tries to pass the $page variable if it's set. Devise sets this when a client loads a page registered with Devise. This head function renders a bunch of stuff automagically: Devise information, meta tags, and Google's Tag Manager if you're using Mothership.

1. The app is registered on the main wrapping ```<div id="app">``` and should wrap everything along with an inner ```<devise>``` tag. The three nodes within are slots that are rendered in that order. The top and bottom slots are perfect for global navigation and / or footers and are not required but can be useful. The static-content slot renders above any slices and the static-content-bottom slot renders below any dynamic slices. 

1. Then we include the devise manifest and javascript at the bottom.

## Create your first slice

Slices are rendered between the static content sections by Devise. These slices can be singles, repeatables (driven by the content manager manually), or driven by custom models (repeat based on the number of records you hand it).

Let's make a simple video Hero slice that we will put at the top of our homepage and save it as ```/resources/views/slices/vimeo-hero.blade.php```

```
@section('template')
<div>
  <div>
    <iframe :src="'https://player.vimeo.com/video/' + devise.vimeoId.text + '?autoplay=1&loop=1&background=1'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
  </div>
</div>
@endsection

@section('component')
  <script>
    let module = {
      config: {
        vimeoId: {
          type: 'number',
          label: 'Vimeo ID'
        }
      }
    }
  </script>
@endsection
```

So, what's in this file? There are two primary sections:

1. The template: This contains traditionally php and Laravel Blade syntax that you're probably familiar with. Additionally, you can utilize devise variables that you define in the component section of this file. For example: Here we use ```devise.vimeoId.text```.

1. The component: In the component section we define our fields. Here we define the ```vimeoId``` field and tell Devise it's a number field-type and that we want our content editors to see the label "Vimeo ID" when they are editing. 
