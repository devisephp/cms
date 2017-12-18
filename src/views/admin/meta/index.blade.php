@extends('devise::admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('/packages/devisephp/cms/css/devise-vue.css') }}" type="text/css" rel="stylesheet">
@stop

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-android-menu"></span> Global Meta Values</h1>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-vertical">
      <h4>Global Meta</h4>
      <div id="app"></div>
    </div>

    <script>
      window.mode = "meta"
    </script>

    {{-- <script src="https://localhost:8080/app.js"></script> --}}

    <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue-manifest.js"></script>
    <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue-vendor.js"></script>
    <script type=text/javascript src="/packages/devisephp/cms/js/devise-vue.js"></script>
@stop
