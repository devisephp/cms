@extends('devise::admin.layouts.media-manager')

@section('css')
    <link href="{{ URL::asset('/packages/devisephp/cms/css/devise-vue.css') }}" type="text/css" rel="stylesheet">
@stop

@section('main')
  <div id="app"></div>
  <script>
    window.mode = "media"
  </script>
	{{-- <script src="https://localhost:8080/app.js"></script> --}}

  <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue-manifest.js"></script>
  <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue-vendor.js"></script>
  <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue.js"></script>

@stop
