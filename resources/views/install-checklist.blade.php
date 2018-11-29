<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to Devise</title>

    <link rel="stylesheet" type="text/css" href="{{ mix('/css/devise.css', '/devise') }}"/>
    
  </head>
  <body class="dvs-bg-grey-lightest dvs-text-grey-darker dvs-overflow-hidden">

    <div id="installer-app">

        <div class="dvs-flex dvs-justify-center dvs-items-center dvs-min-h-screen" slot="static-content">
          <div class="dvs-container dvs-mx-auto">

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
