@extends('devise::layouts.master')

@section('main')
    {{ Form::open(array('method' => 'POST', 'route' => 'dvs_template_store')) }}
        <dl>
        @foreach ($items as $index => $item)
            @include('devise::templates.importer-fields.' . $item['type'])
        @endforeach
        </dl>
        {{ Form::submit('save') }}

    {{ Form::close() }}
@stop