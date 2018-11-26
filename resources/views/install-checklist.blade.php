<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to Devise</title>
  </head>
  <body class="dvs-bg-grey-lightest dvs-text-grey-darker">

    <div id="app">
      <devise>

        <div class="dvs-flex dvs-justify-center dvs-items-center dvs-min-h-screen" slot="static-content">
          <div class="dvs-max-w-3/4 lg:dvs-max-w-1/2 ">

            <h1 class="dvs-mb-8 dvs-font-light">Welcome to Devise</h1>

            <p class="dvs-text-lg">
              We are very excited that you are giving Devise 2 a spin. We are still in the early beta stages of this product so things may change but until then we encourage you to check out the project, submit any PR's or suggestions on Github.
            </p>

          </div>
        </div>

      </devise>
    </div>

  </body>
</html>
