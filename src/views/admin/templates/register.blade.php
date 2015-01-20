@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Register New Template</h1>

        <p>Use the form below to register a new template. Begin by selecting a filename from the list of unregistered filenames.</p>
    </div>

    <div id="dvs-admin-actions">
        {{ link_to(URL::route('dvs-templates'), 'List of Templates', array('class'=>'dvs-button')) }}
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        {{ Form::open(array('method' => 'POST', 'route' => array('dvs-templates-store'))) }}

            <div class="dvs-form-group">
                {{ Form::label('File Name') }}
                {{ Form::select('file_name', [0 => 'Choose an option'] + $unregisteredTemplatesList) }}
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Human Name') }}
                {{ Form::text('human_name') }}
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Extends') }}
                {{ Form::text('extends') }}
            </div>

            {{ Form::submit('Register Template', array('class' => 'dvs-button dvs-button-large')) }}
        {{ Form::close() }}
    </div>
@stop
