<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  @isset($page)
    {!! Devise::head($page) !!}
  @else
    {!! Devise::head() !!}
  @endif

  @if(Auth::user())
    <link href=/devise/css/chunk-vendors.css rel=stylesheet>
    <link href=/devise/css/main.css rel=stylesheet>
    <link href=/devise/css/styles.css rel=stylesheet>
  @endif

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<div id="app">
  <div v-cloak>
    <devise>
      <div slot="on-top"></div>

      <div slot="static-content">
        @yield('content')
      </div>

      <div slot="on-bottom"></div>
    </devise>
  </div>
</div>

<script rel="prefetch" src="{{vuemix('js/chunk-vendors.js', '/devise')}}"></script>
<script rel="prefetch" src="{{vuemix('js/main.js', '/devise')}}"></script>
</body>
</html>