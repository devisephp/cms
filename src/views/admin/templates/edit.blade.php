@extends('devise::layouts.master')

@section('main')
    {{ Session::get('message') }}
    {{ implode('', $errors->all('<li class="error">:message')) }}
    {{ Form::model($template,array('method' => 'PUT', 'route' => array('dvs_template_update', $template->id), 'files' => true)) }}
        {{ Form::text('name') }}
        {{ Form::text('blade') }}
        {{ Form::submit('save') }}
    {{ Form::close() }}
@stop