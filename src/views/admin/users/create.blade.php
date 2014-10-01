@extends('devise::admin.layouts.master')

@section('subnavigation')
    <ul>
        <li><a class="dvs-button" href="{{ route('dvs-users') }}">List of Users</a></li>
    </ul>
@stop

@section('title')

<h1>Create a New User</h1>
<h3><span>About This</span></h3>
<p>Bacon ipsum dolor sit amet pork loin chicken doner leberkas, tail jerky brisket kevin jowl meatloaf prosciutto beef ham hock meatball fatback. Turkey kevin tenderloin, pork shank boudin andouille landjaeger cow meatloaf hamburger shankle strip steak pork belly tongue. </p>

@stop

@section('main')
    <div class="dvs-admin-form-horizontal">

        {{ Form::open(array('route' => 'dvs-users-store')) }}
            <div class="dvs-form-group">
                {{ Form::label('User Group') }}
                {{ Form::select('group_id', array_merge(array(0 => 'Choose an option'), $groups)) }}
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