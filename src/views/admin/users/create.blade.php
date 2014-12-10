@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Create New User</h1>

        <p>Add new users and define their group association.</p>
    </div>

    <div id="dvs-admin-actions">
        {{ link_to(URL::route('dvs-users'), 'List of Users', array('class'=>'dvs-button')) }}
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        {{ Form::open(array('route' => 'dvs-users-store')) }}
            <div class="dvs-form-group">
                {{ Form::label('User Group') }}
                {{ Form::select('group_id', array_merge(array(0 => 'Choose an option'), $groups)) }}
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Name') }}
                {{ Form::text('name') }}
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Email') }}
                {{ Form::text('email') }}
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Password') }}
                {{ Form::password('password') }}
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Confirm Password') }}
                {{ Form::password('password_confirmation') }}
            </div>

            {{ Form::submit('Create User', ['class' => 'dvs-button dvs-button-large']) }}
        {{ Form::close() }}
    </div>
@stop