<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to Devise</title>

    <script src="{{mix('/manifest.js', '/devise')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{ mix('/css/devise.css', '/devise') }}"/>
    
  </head>
  <body class="dvs-bg-grey-lightest dvs-text-grey-darker">

    <div id="installer-app">

        <div class="dvs-flex dvs-justify-center dvs-items-center dvs-min-h-screen" slot="static-content">
          <div class="dvs-container dvs-mx-auto">

            <h1 class="dvs-mb-8 dvs-font-light">Welcome to Devise</h1>

            <p class="dvs-text-xl dvs-mb-16">
              We are very excited that you are giving Devise 2 a spin. We are still in the early beta stages of this product so things may change but until then we encourage you to check out the project, submit any PR's or suggestions on Github.
            </p>

            <devise-installer>
              <div class="dvs-bg-green-lightest dvs-p-8 dvs-pl-16 dvs-border dvs-rounded dvs-border-green dvs-text-green">
                <p class="dvs-mb-4">
                  To get started you will need to publish Devise's assets to your application's public directory. Please run the following from your project's directory on the command line.
                </p>
                <code class="dvs-bg-grey-light dvs-border-grey dvs-border-l-8 dvs-p-4 dvs-text-black">
                  php artisan vendor:publish --tag=dvs-assets
                </code>
              </div>
            </devise-installer>

          </div>
        </div>

    </div>

    
    <script src="{{mix('/js/devise-installer.js', '/devise')}}"></script>

  </body>
</html>
