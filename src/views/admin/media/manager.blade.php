@extends('devise::admin.layouts.media-manager')

@section('main')
  <div id="app"></div>
  <script>
    window.input = {{ json_encode($input) }}
  </script>
	<script src="http://localhost:8080/app.js"></script>

@stop
