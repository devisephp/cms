@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1>Editing User</h1>

        <p>Update user details and set any group association(s).</p>
    </div>

    <div id="dvs-admin-actions">
        {{ link_to(URL::route('dvs-users'), 'List of Users', array('class'=>'dvs-button')) }}
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        {{ Form::open(array('method' => 'PUT', 'route' => array('dvs-users-update', $user->id))) }}

            <div class="dvs-form-group">
                {{ Form::label('Group(s)') }}
                @foreach ($groups as $groupId => $groupName)
                    {{ Form::checkbox('group_id[]', $groupId, in_array($groupId, array_keys($usersGroups))) }} {{ $groupName }}
                @endforeach
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Name') }}
                {{ Form::text('name', $user->name) }}
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Email') }}
                {{ Form::text('email', $user->email) }}
            </div>

            <div class="dvs-form-group">
                <label for="password">Password (enter only to change)</label>
                {{ Form::password('password') }}
            </div>

            <div class="dvs-form-group">
                {{ Form::label('Confirm Password') }}
                {{ Form::password('password_confirmation') }}
            </div>

            {{ Form::submit('Update User', ['class' => 'dvs-button dvs-button-large']) }}<br>
        {{ Form::close() }}
    </div>
@stop