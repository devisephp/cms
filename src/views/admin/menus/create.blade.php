@extends('devise::admin.layouts.master')

@section('title')
    <h1>Create Menu</h1>
@stop

@section('main')
    <div class="dvs-admin-form-horizontal">
        {{ Form::open(array('route' => array('dvs-menus-store'))) }}
    		<div class="dvs-form-group">
    		    {{ Form::label('Menu Name') }}
    		    {{ Form::text('name', $menu->name, array('placeholder' => 'Menu Name')) }}
    		</div>

    		{{ Form::submit('Save Menu', array('class' => 'dvs-button dvs-button-large')) }}
        {{ Form::close() }}
    </div>
@stop