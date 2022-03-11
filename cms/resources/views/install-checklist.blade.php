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

    <link rel="stylesheet" href="/devise/css/prism-line-numbers.css">
    <link rel="stylesheet" href="/devise/css/themes/prism-okaidia.css">

    <link rel="stylesheet" href="{{vuemix('/css/devise-installer.css', '/devise')}}">
    <link rel="stylesheet" href="{{vuemix('/css/chunk-vendors.css', '/devise')}}">
    <link rel="stylesheet" href="{{vuemix('/css/styles.css', '/devise')}}">
  </head>

  <body>
    <div id="app">
        <div v-cloak class="dvs-p-16">
            <devise-installer>
              <div class="dvs-bg-green-lightest dvs-p-8 dvs-pl-16 dvs-border dvs-rounded dvs-border-green dvs-text-green">
                <p class="dvs-mb-8">
                  To get started you will need to publish Devise's assets to your application's public directory. Please run the following from your project's directory on the command line.
                </p>
                <code class="dvs-bg-grey-light dvs-border-grey dvs-border-l-8 dvs-p-4 dvs-text-black">
                  php artisan vendor:publish --tag=dvs-assets
                </code>
              </div>
            </devise-installer>
        </div>
    </div>

    
    <script rel="prefetch" src="{{vuemix('/js/chunk-vendors.js', '/app')}}"></script>
    <script rel="prefetch" src="{{vuemix('/js/app.js', '/app')}}"></script>
  </body>
</html>