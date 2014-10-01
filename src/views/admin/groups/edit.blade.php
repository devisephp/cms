@extends('devise::admin.layouts.master')

@section('subnavigation')
<ul>
    <li>{{ link_to(URL::route('dvs-groups'), 'List of Groups', array('class'=>'dvs-button')) }}</li>
</ul>
@stop

@section('title')
	<h1>Edit Group</h1>
@stop

@section('main')
	<div class="dvs-admin-form-horizontal">
	    {{ Form::model($group, array('method' => 'PUT', 'route' => array('dvs-groups-update', $group->id))) }}
            <div class="dvs-form-group">
    	        {{ Form::label('Name') }}
    	        {{ Form::text('name', $group->name) }}
            </div>
            
	        {{ Form::submit('Update Group', ['class' => 'dvs-button dvs-button-large']) }}<br>
	    {{ Form::close() }}
	</div>
@stop