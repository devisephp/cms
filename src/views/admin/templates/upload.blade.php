@extends('devise::layouts.master')

@section('main')
	{{ Form::open(array('method' => 'POST', 'route' => 'dvs_template_review', 'files' => true)) }}
		{{ Form::file('file') }}
		{{ Form::submit('Upload') }}
	{{ Form::close() }}
    <hr />
    <hr />
    <hr />
    <hr />

    {{ Form::open(array('method' => 'POST', 'route' => 'dvs_template_review', 'files' => true)) }}
        View Path: {{ Form::text('view') }}
        {{ Form::submit('Scan') }}
    {{ Form::close() }}
@stop